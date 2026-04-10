<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="/" style="display:inline-grid;grid-template-columns:auto auto auto;grid-template-rows:auto auto;column-gap:12px;row-gap:6px;align-items:center;text-decoration:none;">
            <span style="grid-column:1;grid-row:1;align-self:end;white-space:nowrap;" class="font-serif font-extrabold text-xl text-gray-900 leading-none tracking-tight">Pharmacy Owner</span>
            <span style="grid-column:2;grid-row:1;align-self:end;" class="font-serif italic font-semibold text-lg text-green-600 leading-none">by</span>
            <img src="{{ asset('images/p3-logo.png') }}" alt="P3" style="grid-column:3;grid-row:1 / 3;align-self:center;" class="h-12 w-auto">
            <span style="grid-column:1;grid-row:2;display:flex;justify-content:space-between;" class="text-[9px] font-semibold text-gray-500 tracking-widest uppercase">
                <span>Intelligence</span><span>&middot;</span><span>Analysis</span><span>&middot;</span><span>Insight</span>
            </span>
        </a>
        <h2 class="mt-6 text-center text-2xl font-bold text-gray-900">Create your account</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">Sign in</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
        <!-- Progress Bar -->
        <div class="mb-8 px-4">
            <div class="flex items-center justify-between mb-2">
                @for ($i = 1; $i <= $totalSteps; $i++)
                    <button 
                        wire:click="goToStep({{ $i }})"
                        @class([
                            'w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium transition-colors',
                            'bg-green-600 text-white' => $i < $currentStep,
                            'bg-green-600 text-white ring-4 ring-green-100' => $i === $currentStep,
                            'bg-gray-200 text-gray-600' => $i > $currentStep,
                            'cursor-pointer hover:bg-green-700' => $i < $currentStep,
                            'cursor-default' => $i >= $currentStep,
                        ])
                        @if($i > $currentStep) disabled @endif
                    >
                        @if ($i < $currentStep)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            {{ $i }}
                        @endif
                    </button>
                    @if ($i < $totalSteps)
                        <div @class([
                            'flex-1 h-1 mx-2 rounded',
                            'bg-green-600' => $i < $currentStep,
                            'bg-gray-200' => $i >= $currentStep,
                        ])></div>
                    @endif
                @endfor
            </div>
            <div class="flex justify-between text-xs text-gray-500">
                <span>Account</span>
                <span>Personal</span>
                <span>Pharmacy</span>
                <span>Consent</span>
            </div>
        </div>

        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-xl sm:px-10">
            <form wire:submit="@if($currentStep === $totalSteps) register @else nextStep @endif">
                
                {{-- Step 1: Account --}}
                @if ($currentStep === 1)
                    <div class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input 
                                wire:model="email" 
                                type="email" 
                                id="email"
                                autocomplete="email"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('email') border-red-500 @enderror"
                            >
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input 
                                wire:model="password" 
                                type="password" 
                                id="password"
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('password') border-red-500 @enderror"
                            >
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm password</label>
                            <input 
                                wire:model="password_confirmation" 
                                type="password" 
                                id="password_confirmation"
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            >
                        </div>
                    </div>
                @endif

                {{-- Step 2: Personal --}}
                @if ($currentStep === 2)
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                                <input 
                                    wire:model="first_name" 
                                    type="text" 
                                    id="first_name"
                                    autocomplete="given-name"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('first_name') border-red-500 @enderror"
                                >
                                @error('first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                                <input 
                                    wire:model="last_name" 
                                    type="text" 
                                    id="last_name"
                                    autocomplete="family-name"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('last_name') border-red-500 @enderror"
                                >
                                @error('last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="job_title" class="block text-sm font-medium text-gray-700">Job title</label>
                            <select 
                                wire:model.live="job_title" 
                                id="job_title"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('job_title') border-red-500 @enderror"
                            >
                                <option value="">Select your role...</option>
                                @foreach ($this->jobTitleOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('job_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        @if ($this->requiresGphc)
                            <div x-data x-transition>
                                <label for="gphc_number" class="block text-sm font-medium text-gray-700">GPhC registration number</label>
                                <input 
                                    wire:model="gphc_number" 
                                    type="text" 
                                    id="gphc_number"
                                    maxlength="7"
                                    placeholder="e.g., 2012345"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('gphc_number') border-red-500 @enderror"
                                >
                                <p class="mt-1 text-xs text-gray-500">Your 7-digit GPhC registration number</p>
                                @error('gphc_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Step 3: Pharmacy Context --}}
                @if ($currentStep === 3)
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Do you currently own a pharmacy?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input wire:model.live="currently_own_pharmacy" type="radio" value="1" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input wire:model.live="currently_own_pharmacy" type="radio" value="0" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">No</span>
                                </label>
                            </div>
                        </div>

                        @if ($currently_own_pharmacy)
                            <div x-data x-transition>
                                <label for="number_of_pharmacies" class="block text-sm font-medium text-gray-700">How many pharmacies do you own?</label>
                                <input 
                                    wire:model="number_of_pharmacies" 
                                    type="number" 
                                    id="number_of_pharmacies"
                                    min="1"
                                    class="mt-1 block w-32 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('number_of_pharmacies') border-red-500 @enderror"
                                >
                                @error('number_of_pharmacies') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <div>
                            <label for="current_workplace" class="block text-sm font-medium text-gray-700">Which pharmacy do you work for? <span class="text-gray-400">(optional)</span></label>
                            <input 
                                wire:model="current_workplace" 
                                type="text" 
                                id="current_workplace"
                                placeholder="Pharmacy name and location"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Are you looking to buy a pharmacy?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input wire:model.live="looking_to_buy" type="radio" value="1" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input wire:model.live="looking_to_buy" type="radio" value="0" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <span class="ml-2 text-sm text-gray-700">No</span>
                                </label>
                            </div>
                        </div>

                        @if ($looking_to_buy)
                            <div x-data x-transition class="space-y-4">
                                <div>
                                    <label for="buy_location_preference" class="block text-sm font-medium text-gray-700">Where are you looking to buy?</label>
                                    <input 
                                        wire:model="buy_location_preference" 
                                        type="text" 
                                        id="buy_location_preference"
                                        placeholder="e.g., London, South East, Anywhere in UK"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('buy_location_preference') border-red-500 @enderror"
                                    >
                                    @error('buy_location_preference') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="buy_timeframe" class="block text-sm font-medium text-gray-700">When are you looking to buy?</label>
                                    <select 
                                        wire:model="buy_timeframe" 
                                        id="buy_timeframe"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('buy_timeframe') border-red-500 @enderror"
                                    >
                                        <option value="">Select timeframe...</option>
                                        @foreach ($this->buyTimeframeOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('buy_timeframe') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Step 4: Consent --}}
                @if ($currentStep === 4)
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Almost there!</h3>
                            <p class="text-sm text-gray-600">Please review and accept the following to complete your registration.</p>
                        </div>

                        <div class="space-y-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input 
                                    wire:model="newsletter_optin" 
                                    type="checkbox" 
                                    class="mt-0.5 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                >
                                <span class="text-sm text-gray-700">
                                    Send me the weekly Pharmacy Owner by P3 newsletter with industry news, new listings, and insights.
                                </span>
                            </label>

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input 
                                    wire:model="terms_accepted" 
                                    type="checkbox" 
                                    class="mt-0.5 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded @error('terms_accepted') border-red-500 @enderror"
                                >
                                <span class="text-sm text-gray-700">
                                    I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-green-600 hover:underline">Terms of Service</a> <span class="text-red-500">*</span>
                                </span>
                            </label>
                            @error('terms_accepted') <p class="text-sm text-red-600 ml-7">{{ $message }}</p> @enderror

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input 
                                    wire:model="privacy_accepted" 
                                    type="checkbox" 
                                    class="mt-0.5 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded @error('privacy_accepted') border-red-500 @enderror"
                                >
                                <span class="text-sm text-gray-700">
                                    I agree to the <a href="{{ route('privacy') }}" target="_blank" class="text-green-600 hover:underline">Privacy Policy</a> <span class="text-red-500">*</span>
                                </span>
                            </label>
                            @error('privacy_accepted') <p class="text-sm text-red-600 ml-7">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif

                {{-- Navigation Buttons --}}
                <div class="mt-8 flex justify-between">
                    @if ($currentStep > 1)
                        <button 
                            type="button"
                            wire:click="previousStep"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            Back
                        </button>
                    @else
                        <div></div>
                    @endif

                    <button 
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-75 cursor-wait"
                        class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-75"
                    >
                        <span wire:loading.remove>
                            @if ($currentStep === $totalSteps)
                                Create Account
                            @else
                                Continue
                            @endif
                        </span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
