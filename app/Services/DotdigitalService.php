<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DotdigitalService
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;

    // Address book IDs from Dotdigital
    protected const ADDRESS_BOOKS = [
        'newsletter' => 'NEWSLETTER_ADDRESS_BOOK_ID',
        'buyers' => 'BUYERS_ADDRESS_BOOK_ID',
        'agents' => 'AGENTS_ADDRESS_BOOK_ID',
        'suppliers' => 'SUPPLIERS_ADDRESS_BOOK_ID',
    ];

    // Campaign/Template IDs
    protected const CAMPAIGNS = [
        'welcome' => 'WELCOME_CAMPAIGN_ID',
        'email_verification' => 'EMAIL_VERIFICATION_CAMPAIGN_ID',
        'password_reset' => 'PASSWORD_RESET_CAMPAIGN_ID',
        'new_listing_alert' => 'NEW_LISTING_ALERT_CAMPAIGN_ID',
        'enquiry_received' => 'ENQUIRY_RECEIVED_CAMPAIGN_ID',
        'enquiry_confirmation' => 'ENQUIRY_CONFIRMATION_CAMPAIGN_ID',
        'course_purchase' => 'COURSE_PURCHASE_CAMPAIGN_ID',
        'course_completion' => 'COURSE_COMPLETION_CAMPAIGN_ID',
        'listing_published' => 'LISTING_PUBLISHED_CAMPAIGN_ID',
        'listing_expiring' => 'LISTING_EXPIRING_CAMPAIGN_ID',
        'subscription_welcome' => 'SUBSCRIPTION_WELCOME_CAMPAIGN_ID',
        'subscription_renewal' => 'SUBSCRIPTION_RENEWAL_CAMPAIGN_ID',
        'subscription_cancelled' => 'SUBSCRIPTION_CANCELLED_CAMPAIGN_ID',
        'payment_failed' => 'PAYMENT_FAILED_CAMPAIGN_ID',
        'weekly_newsletter' => 'WEEKLY_NEWSLETTER_CAMPAIGN_ID',
    ];

    public function __construct()
    {
        $this->baseUrl = config('services.dotdigital.base_url', 'https://r1-api.dotdigital.com');
        $this->username = config('services.dotdigital.username');
        $this->password = config('services.dotdigital.password');
    }

    /**
     * Sync a user contact to Dotdigital.
     */
    public function syncContact(User $user): bool
    {
        $contact = [
            'email' => $user->email,
            'optInType' => 'Single',
            'emailType' => 'Html',
            'dataFields' => $this->mapUserToDataFields($user),
        ];

        try {
            $response = $this->request('POST', '/v2/contacts', $contact);
            
            // Add to appropriate address books
            if ($user->newsletter_subscribed) {
                $this->addToAddressBook($user->email, 'newsletter');
            }

            if ($user->looking_to_buy) {
                $this->addToAddressBook($user->email, 'buyers');
            }

            if ($user->isEstateAgent()) {
                $this->addToAddressBook($user->email, 'agents');
            }

            if ($user->isSupplier()) {
                $this->addToAddressBook($user->email, 'suppliers');
            }

            Log::info('Contact synced to Dotdigital', ['email' => $user->email]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to sync contact to Dotdigital', [
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send a triggered campaign.
     */
    public function sendTriggeredCampaign(string $campaignKey, string $email, array $personalization = []): bool
    {
        $campaignId = self::CAMPAIGNS[$campaignKey] ?? null;
        
        if (!$campaignId || $campaignId === strtoupper($campaignKey) . '_CAMPAIGN_ID') {
            Log::warning('Campaign ID not configured', ['campaign' => $campaignKey]);
            return false;
        }

        $payload = [
            'toAddresses' => [$email],
            'campaignId' => $campaignId,
            'personalizationValues' => $this->formatPersonalization($personalization),
        ];

        try {
            $this->request('POST', '/v2/email/triggered-campaign', $payload);
            Log::info('Triggered campaign sent', ['campaign' => $campaignKey, 'email' => $email]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send triggered campaign', [
                'campaign' => $campaignKey,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send welcome email.
     */
    public function sendWelcomeEmail(User $user): bool
    {
        return $this->sendTriggeredCampaign('welcome', $user->email, [
            'FIRSTNAME' => $user->first_name,
            'JOBTITLE' => $user->job_title?->label(),
        ]);
    }

    /**
     * Send email verification link.
     */
    public function sendEmailVerification(User $user, string $verificationUrl): bool
    {
        return $this->sendTriggeredCampaign('email_verification', $user->email, [
            'FIRSTNAME' => $user->first_name,
            'VERIFICATION_URL' => $verificationUrl,
        ]);
    }

    /**
     * Send password reset link.
     */
    public function sendPasswordReset(User $user, string $resetUrl): bool
    {
        return $this->sendTriggeredCampaign('password_reset', $user->email, [
            'FIRSTNAME' => $user->first_name,
            'RESET_URL' => $resetUrl,
        ]);
    }

    /**
     * Send new listing alert to saved search subscribers.
     */
    public function sendNewListingAlert(string $email, array $listingData): bool
    {
        return $this->sendTriggeredCampaign('new_listing_alert', $email, [
            'LISTING_TITLE' => $listingData['title'],
            'LISTING_PRICE' => $listingData['price'],
            'LISTING_LOCATION' => $listingData['location'],
            'LISTING_URL' => $listingData['url'],
        ]);
    }

    /**
     * Send enquiry received notification to agent.
     */
    public function sendEnquiryReceivedNotification(string $agentEmail, array $enquiryData): bool
    {
        return $this->sendTriggeredCampaign('enquiry_received', $agentEmail, [
            'LISTING_TITLE' => $enquiryData['listing_title'],
            'ENQUIRER_NAME' => $enquiryData['enquirer_name'],
            'ENQUIRER_EMAIL' => $enquiryData['enquirer_email'],
            'ENQUIRER_PHONE' => $enquiryData['enquirer_phone'] ?? '',
            'MESSAGE' => $enquiryData['message'],
            'DASHBOARD_URL' => route('agent.enquiries.index'),
        ]);
    }

    /**
     * Send enquiry confirmation to user.
     */
    public function sendEnquiryConfirmation(string $email, array $data): bool
    {
        return $this->sendTriggeredCampaign('enquiry_confirmation', $email, [
            'FIRSTNAME' => $data['first_name'],
            'LISTING_TITLE' => $data['listing_title'],
            'AGENT_NAME' => $data['agent_name'],
        ]);
    }

    /**
     * Send course purchase confirmation.
     */
    public function sendCoursePurchaseConfirmation(User $user, array $courseData): bool
    {
        return $this->sendTriggeredCampaign('course_purchase', $user->email, [
            'FIRSTNAME' => $user->first_name,
            'COURSE_TITLE' => $courseData['title'],
            'COURSE_URL' => $courseData['url'],
            'AMOUNT' => $courseData['amount'],
        ]);
    }

    /**
     * Send course completion certificate.
     */
    public function sendCourseCompletionCertificate(User $user, array $courseData): bool
    {
        return $this->sendTriggeredCampaign('course_completion', $user->email, [
            'FIRSTNAME' => $user->first_name,
            'COURSE_TITLE' => $courseData['title'],
            'COMPLETION_DATE' => $courseData['completion_date'],
            'CPD_POINTS' => $courseData['cpd_points'] ?? '0',
            'CERTIFICATE_URL' => $courseData['certificate_url'] ?? '',
        ]);
    }

    /**
     * Add contact to an address book.
     */
    public function addToAddressBook(string $email, string $bookKey): bool
    {
        $bookId = self::ADDRESS_BOOKS[$bookKey] ?? null;
        
        if (!$bookId || strpos($bookId, '_ADDRESS_BOOK_ID') !== false) {
            Log::warning('Address book ID not configured', ['book' => $bookKey]);
            return false;
        }

        try {
            $this->request('POST', "/v2/address-books/{$bookId}/contacts", [
                'email' => $email,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to add to address book', [
                'email' => $email,
                'book' => $bookKey,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Remove contact from an address book.
     */
    public function removeFromAddressBook(string $email, string $bookKey): bool
    {
        $bookId = self::ADDRESS_BOOKS[$bookKey] ?? null;
        
        if (!$bookId) {
            return false;
        }

        try {
            // First get contact ID
            $contact = $this->request('GET', "/v2/contacts/{$email}");
            $contactId = $contact['id'] ?? null;
            
            if ($contactId) {
                $this->request('DELETE', "/v2/address-books/{$bookId}/contacts/{$contactId}");
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to remove from address book', [
                'email' => $email,
                'book' => $bookKey,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Unsubscribe a contact.
     */
    public function unsubscribe(string $email): bool
    {
        try {
            $this->request('POST', '/v2/contacts/unsubscribe', [
                'email' => $email,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to unsubscribe contact', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Map user model to Dotdigital data fields.
     */
    protected function mapUserToDataFields(User $user): array
    {
        return [
            ['key' => 'FIRSTNAME', 'value' => $user->first_name],
            ['key' => 'LASTNAME', 'value' => $user->last_name],
            ['key' => 'FULLNAME', 'value' => $user->full_name],
            ['key' => 'JOBTITLE', 'value' => $user->job_title?->label() ?? ''],
            ['key' => 'GPHCNUMBER', 'value' => $user->gphc_number ?? ''],
            ['key' => 'CURRENTWORKPLACE', 'value' => $user->current_workplace ?? ''],
            ['key' => 'OWNSPHARMACY', 'value' => $user->currently_own_pharmacy ? 'Yes' : 'No'],
            ['key' => 'NUMBEROFPHARMACIES', 'value' => (string) ($user->number_of_pharmacies ?? 0)],
            ['key' => 'LOOKINGTOBUY', 'value' => $user->looking_to_buy ? 'Yes' : 'No'],
            ['key' => 'BUYLOCATIONPREFERENCE', 'value' => $user->buy_location_preference ?? ''],
            ['key' => 'USERROLE', 'value' => $user->role->value],
            ['key' => 'REGISTRATIONDATE', 'value' => $user->created_at->format('Y-m-d')],
        ];
    }

    /**
     * Format personalization values for API.
     */
    protected function formatPersonalization(array $values): array
    {
        $formatted = [];
        foreach ($values as $key => $value) {
            $formatted[] = [
                'name' => $key,
                'value' => (string) $value,
            ];
        }
        return $formatted;
    }

    /**
     * Make an API request.
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->accept('application/json')
            ->contentType('application/json')
            ->{strtolower($method)}($this->baseUrl . $endpoint, $data);

        if (!$response->successful()) {
            throw new \Exception("Dotdigital API error: {$response->status()} - {$response->body()}");
        }

        return $response->json() ?? [];
    }
}
