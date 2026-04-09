<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CoursePurchase;
use App\Models\PropertyListing;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Subscription;
use Stripe\Webhook;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a checkout session for a course purchase.
     */
    public function createCourseCheckout(User $user, Course $course): Session
    {
        $customer = $this->getOrCreateCustomer($user);

        return Session::create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => $course->title,
                        'description' => 'CPD Course - ' . ($course->cpd_accredited ? $course->cpd_points . ' CPD points' : 'Non-accredited'),
                        'metadata' => [
                            'course_id' => $course->id,
                        ],
                    ],
                    'unit_amount' => $course->price, // Already in pence
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('training.purchase-success', ['course' => $course->slug]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('training.show', $course->slug),
            'metadata' => [
                'type' => 'course_purchase',
                'course_id' => $course->id,
                'user_id' => $user->id,
            ],
        ]);
    }

    /**
     * Create a checkout session for a property listing.
     */
    public function createListingCheckout(User $user, PropertyListing $listing, string $tier): Session
    {
        $customer = $this->getOrCreateCustomer($user);
        
        $prices = config('services.stripe.listing_prices');
        $price = $prices[$tier] ?? $prices['standard'];

        return Session::create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => ucfirst($tier) . ' Listing - ' . $listing->title,
                        'description' => $this->getListingTierDescription($tier),
                    ],
                    'unit_amount' => $price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('agent.listings.payment-success', ['listing' => $listing->id]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('agent.listings.edit', $listing->id),
            'metadata' => [
                'type' => 'listing_payment',
                'listing_id' => $listing->id,
                'user_id' => $user->id,
                'tier' => $tier,
            ],
        ]);
    }

    /**
     * Create a subscription checkout for a supplier.
     */
    public function createSupplierSubscription(User $user, Supplier $supplier, string $tier, string $interval = 'month'): Session
    {
        $customer = $this->getOrCreateCustomer($user);
        
        $priceId = config("services.stripe.supplier_prices.{$tier}.{$interval}");
        
        if (!$priceId) {
            throw new \InvalidArgumentException("Invalid tier or interval: {$tier}/{$interval}");
        }

        return Session::create([
            'customer' => $customer->id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('supplier.subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('supplier.subscription.index'),
            'metadata' => [
                'type' => 'supplier_subscription',
                'supplier_id' => $supplier->id,
                'user_id' => $user->id,
                'tier' => $tier,
            ],
        ]);
    }

    /**
     * Handle Stripe webhook events.
     */
    public function handleWebhook(string $payload, string $signature): void
    {
        $event = Webhook::constructEvent(
            $payload,
            $signature,
            config('services.stripe.webhook_secret')
        );

        Log::info('Stripe webhook received', ['type' => $event->type]);

        match ($event->type) {
            'checkout.session.completed' => $this->handleCheckoutCompleted($event->data->object),
            'customer.subscription.updated' => $this->handleSubscriptionUpdated($event->data->object),
            'customer.subscription.deleted' => $this->handleSubscriptionDeleted($event->data->object),
            'invoice.payment_failed' => $this->handlePaymentFailed($event->data->object),
            default => null,
        };
    }

    /**
     * Handle successful checkout completion.
     */
    protected function handleCheckoutCompleted(Session $session): void
    {
        $metadata = $session->metadata;

        match ($metadata->type ?? null) {
            'course_purchase' => $this->completeCoursePayment($session),
            'listing_payment' => $this->completeListingPayment($session),
            'supplier_subscription' => $this->completeSupplierSubscription($session),
            default => Log::warning('Unknown checkout type', ['metadata' => $metadata]),
        };
    }

    /**
     * Complete a course purchase.
     */
    protected function completeCoursePayment(Session $session): void
    {
        $courseId = $session->metadata->course_id;
        $userId = $session->metadata->user_id;

        CoursePurchase::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'amount' => $session->amount_total,
            'stripe_payment_intent_id' => $session->payment_intent,
            'status' => 'completed',
            'purchased_at' => now(),
        ]);

        // Create enrolment
        $course = Course::find($courseId);
        $user = User::find($userId);
        
        if ($course && $user) {
            $course->enrolments()->firstOrCreate([
                'user_id' => $user->id,
            ], [
                'status' => 'active',
                'enrolled_at' => now(),
            ]);
        }

        Log::info('Course purchase completed', ['course_id' => $courseId, 'user_id' => $userId]);
    }

    /**
     * Complete a listing payment.
     */
    protected function completeListingPayment(Session $session): void
    {
        $listing = PropertyListing::find($session->metadata->listing_id);
        
        if ($listing) {
            $listing->update([
                'payment_status' => 'paid',
                'payment_id' => $session->payment_intent,
                'listing_tier' => $session->metadata->tier,
                'status' => 'pending_review',
            ]);
        }

        Log::info('Listing payment completed', ['listing_id' => $session->metadata->listing_id]);
    }

    /**
     * Complete a supplier subscription.
     */
    protected function completeSupplierSubscription(Session $session): void
    {
        $supplier = Supplier::find($session->metadata->supplier_id);
        
        if ($supplier) {
            $supplier->update([
                'tier' => $session->metadata->tier,
                'subscription_status' => 'active',
                'stripe_subscription_id' => $session->subscription,
                'stripe_customer_id' => $session->customer,
            ]);
        }

        Log::info('Supplier subscription activated', ['supplier_id' => $session->metadata->supplier_id]);
    }

    /**
     * Handle subscription updates.
     */
    protected function handleSubscriptionUpdated(Subscription $subscription): void
    {
        $supplier = Supplier::where('stripe_subscription_id', $subscription->id)->first();
        
        if ($supplier) {
            $supplier->update([
                'subscription_status' => $subscription->status,
                'subscription_expires_at' => $subscription->current_period_end 
                    ? \Carbon\Carbon::createFromTimestamp($subscription->current_period_end) 
                    : null,
            ]);
        }
    }

    /**
     * Handle subscription deletions.
     */
    protected function handleSubscriptionDeleted(Subscription $subscription): void
    {
        $supplier = Supplier::where('stripe_subscription_id', $subscription->id)->first();
        
        if ($supplier) {
            $supplier->update([
                'tier' => 'free',
                'subscription_status' => 'cancelled',
                'stripe_subscription_id' => null,
            ]);
        }

        Log::info('Supplier subscription cancelled', ['supplier_id' => $supplier?->id]);
    }

    /**
     * Handle failed payments.
     */
    protected function handlePaymentFailed($invoice): void
    {
        $subscriptionId = $invoice->subscription;
        $supplier = Supplier::where('stripe_subscription_id', $subscriptionId)->first();
        
        if ($supplier) {
            $supplier->update([
                'subscription_status' => 'past_due',
            ]);

            // TODO: Send email notification via Dotdigital
        }

        Log::warning('Payment failed', ['subscription_id' => $subscriptionId]);
    }

    /**
     * Get or create a Stripe customer.
     */
    protected function getOrCreateCustomer(User $user): Customer
    {
        if ($user->stripe_customer_id) {
            try {
                return Customer::retrieve($user->stripe_customer_id);
            } catch (ApiErrorException $e) {
                // Customer doesn't exist, create new one
            }
        }

        $customer = Customer::create([
            'email' => $user->email,
            'name' => $user->full_name,
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        $user->update(['stripe_customer_id' => $customer->id]);

        return $customer;
    }

    /**
     * Cancel a supplier subscription.
     */
    public function cancelSubscription(Supplier $supplier): void
    {
        if ($supplier->stripe_subscription_id) {
            $subscription = Subscription::retrieve($supplier->stripe_subscription_id);
            $subscription->cancel();
        }
    }

    /**
     * Get description for listing tier.
     */
    protected function getListingTierDescription(string $tier): string
    {
        return match ($tier) {
            'featured' => '30 days featured placement, highlighted in search results',
            'premium' => '60 days premium listing, top placement, social media promotion',
            default => '30 days standard listing',
        };
    }
}
