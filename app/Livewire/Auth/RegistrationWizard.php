<?php

namespace App\Livewire\Auth;

use App\Enums\BuyTimeframe;
use App\Enums\JobTitle;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class RegistrationWizard extends Component
{
    /**
     * Master switch for email verification on signup.
     *
     * Set to `true` to restore the original flow: a verification link is
     * sent, the user is redirected to the "please check your email" notice,
     * and `verified` middleware blocks the rest of the app until they click
     * the link. Set to `false` to auto-verify every new user and drop them
     * straight into the authenticated home page.
     *
     * The verification controller, mailable, routes and middleware are all
     * still in place - this toggle is the only thing you need to flip when
     * the transactional email pipeline is ready to go live.
     */
    private const REQUIRE_EMAIL_VERIFICATION = false;

    // Step tracking
    public int $currentStep = 1;
    public int $totalSteps = 4;

    // Step 1: Account
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Step 2: Personal
    public string $first_name = '';
    public string $last_name = '';
    public string $job_title = '';
    public string $gphc_number = '';

    // Step 3: Pharmacy Context
    public bool $currently_own_pharmacy = false;
    public ?int $number_of_pharmacies = null;
    public string $current_workplace = '';
    public bool $looking_to_buy = false;
    public string $buy_location_preference = '';
    public string $buy_timeframe = '';

    // Step 4: Consent
    public bool $newsletter_optin = true;
    public bool $terms_accepted = false;
    public bool $privacy_accepted = false;

    public function mount(): void
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            $this->redirect(route('dashboard'));
        }
    }

    public function getJobTitleOptionsProperty(): array
    {
        return JobTitle::options();
    }

    public function getBuyTimeframeOptionsProperty(): array
    {
        return BuyTimeframe::options();
    }

    public function getRequiresGphcProperty(): bool
    {
        if (empty($this->job_title)) {
            return false;
        }
        
        $jobTitle = JobTitle::tryFrom($this->job_title);
        return $jobTitle?->requiresGphc() ?? false;
    }

    public function getProgressPercentageProperty(): int
    {
        return (int) (($this->currentStep / $this->totalSteps) * 100);
    }

    public function nextStep(): void
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep(int $step): void
    {
        // Only allow going back, not forward (must validate)
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    protected function validateCurrentStep(): void
    {
        match ($this->currentStep) {
            1 => $this->validateStep1(),
            2 => $this->validateStep2(),
            3 => $this->validateStep3(),
            4 => $this->validateStep4(),
            default => null,
        };
    }

    protected function validateStep1(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
    }

    protected function validateStep2(): void
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'job_title' => ['required', 'string'],
        ];

        // GPhC validation if required
        if ($this->requiresGphc) {
            $rules['gphc_number'] = ['required', 'string', 'size:7', 'regex:/^\d{7}$/'];
        }

        $this->validate($rules, [
            'gphc_number.required' => 'GPhC number is required for pharmacists.',
            'gphc_number.size' => 'GPhC number must be exactly 7 digits.',
            'gphc_number.regex' => 'GPhC number must contain only numbers.',
        ]);
    }

    protected function validateStep3(): void
    {
        $rules = [
            'currently_own_pharmacy' => ['required', 'boolean'],
            'looking_to_buy' => ['required', 'boolean'],
        ];

        if ($this->currently_own_pharmacy) {
            $rules['number_of_pharmacies'] = ['required', 'integer', 'min:1'];
        }

        if ($this->looking_to_buy) {
            $rules['buy_location_preference'] = ['required', 'string', 'max:255'];
            $rules['buy_timeframe'] = ['required', 'string'];
        }

        $this->validate($rules);
    }

    protected function validateStep4(): void
    {
        $this->validate([
            'terms_accepted' => ['accepted'],
            'privacy_accepted' => ['accepted'],
        ], [
            'terms_accepted.accepted' => 'You must accept the Terms of Service.',
            'privacy_accepted.accepted' => 'You must accept the Privacy Policy.',
        ]);
    }

    public function register(): void
    {
        // Validate final step
        $this->validateStep4();

        // Create user
        $user = User::create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'job_title' => $this->job_title,
            'gphc_number' => $this->requiresGphc ? $this->gphc_number : null,
            'currently_own_pharmacy' => $this->currently_own_pharmacy,
            'number_of_pharmacies' => $this->currently_own_pharmacy ? $this->number_of_pharmacies : null,
            'current_workplace' => $this->current_workplace ?: null,
            'looking_to_buy' => $this->looking_to_buy,
            'buy_location_preference' => $this->looking_to_buy ? $this->buy_location_preference : null,
            'buy_timeframe' => $this->looking_to_buy ? $this->buy_timeframe : null,
            'role' => UserRole::REGISTERED_USER,
            'newsletter_subscribed' => $this->newsletter_optin,
        ]);

        // When verification is disabled, immediately mark the user as
        // verified so the rest of the `verified` middleware keeps working
        // unchanged. `email_verified_at` is not mass-assignable on the
        // User model, so we go through the canonical MustVerifyEmail
        // helper. Flip REQUIRE_EMAIL_VERIFICATION at the top of this
        // class to restore the original flow.
        if (! self::REQUIRE_EMAIL_VERIFICATION) {
            $user->markEmailAsVerified();
        }

        // Fire the Registered event either way. Laravel's default
        // SendEmailVerificationNotification listener is a no-op for users
        // who already have `email_verified_at` set, so this is safe even
        // when verification is disabled, and it keeps any future
        // listeners wired up.
        event(new Registered($user));

        Auth::login($user);

        // Only send the user to the "please verify your email" notice
        // when verification is actually required. Otherwise drop them
        // straight into the authenticated home page.
        $this->redirect(
            self::REQUIRE_EMAIL_VERIFICATION
                ? route('verification.notice')
                : route('home')
        );
    }

    public function render()
    {
        return view('livewire.auth.registration-wizard')
            ->layout('layouts.guest', ['title' => 'Register']);
    }
}
