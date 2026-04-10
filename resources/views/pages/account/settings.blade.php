<x-layouts.app title="Account Settings">
    @php
        $jobTitleOptions = \App\Enums\JobTitle::options();
        $buyTimeframeOptions = \App\Enums\BuyTimeframe::options();
        $jobsRequiringGphc = collect(\App\Enums\JobTitle::cases())
            ->filter(fn ($j) => $j->requiresGphc())
            ->map(fn ($j) => $j->value)
            ->values()
            ->all();
    @endphp

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
         x-data="{
             jobTitle: '{{ old('job_title', $user->job_title?->value) }}',
             ownsPharmacy: {{ old('currently_own_pharmacy', $user->currently_own_pharmacy) ? 'true' : 'false' }},
             lookingToBuy: {{ old('looking_to_buy', $user->looking_to_buy) ? 'true' : 'false' }},
             jobsRequiringGphc: @js($jobsRequiringGphc),
             get requiresGphc() { return this.jobsRequiringGphc.includes(this.jobTitle); },
         }">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Account Settings</h1>
        <p class="text-gray-500 text-sm mb-8">Keep your profile up to date so we can tailor listings, training and market insight to you.</p>

        @if(session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('account.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Personal Information --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                               value="{{ old('first_name', $user->first_name) }}" required
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('first_name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                               value="{{ old('last_name', $user->last_name) }}" required
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('last_name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="job_title" class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                        <select name="job_title" id="job_title" required
                                x-model="jobTitle"
                                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="">— Select —</option>
                            @foreach($jobTitleOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('job_title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div x-show="requiresGphc" x-cloak>
                        <label for="gphc_number" class="block text-sm font-medium text-gray-700 mb-1">GPhC Number</label>
                        <input type="text" name="gphc_number" id="gphc_number"
                               value="{{ old('gphc_number', $user->gphc_number) }}"
                               placeholder="e.g. 2012345"
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        <p class="text-gray-500 text-xs mt-1">Your General Pharmaceutical Council registration number.</p>
                        @error('gphc_number')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Pharmacy Context --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pharmacy Context</h2>

                <div>
                    <label for="current_workplace" class="block text-sm font-medium text-gray-700 mb-1">Current Workplace</label>
                    <input type="text" name="current_workplace" id="current_workplace"
                           value="{{ old('current_workplace', $user->current_workplace) }}"
                           placeholder="e.g. Boots, Lloyds, Independent pharmacy name"
                           class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    @error('current_workplace')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mt-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="hidden" name="currently_own_pharmacy" value="0">
                        <input type="checkbox" name="currently_own_pharmacy" value="1"
                               x-model="ownsPharmacy"
                               class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <div>
                            <span class="font-medium text-gray-900">I currently own one or more pharmacies</span>
                            <p class="text-gray-500 text-sm">Tick this if you already have an ownership interest in a community pharmacy.</p>
                        </div>
                    </label>
                </div>

                <div class="mt-4" x-show="ownsPharmacy" x-cloak>
                    <label for="number_of_pharmacies" class="block text-sm font-medium text-gray-700 mb-1">Number of Pharmacies</label>
                    <input type="number" name="number_of_pharmacies" id="number_of_pharmacies"
                           min="1" max="500"
                           value="{{ old('number_of_pharmacies', $user->number_of_pharmacies) }}"
                           class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    @error('number_of_pharmacies')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Buyer Preferences --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Buyer Preferences</h2>

                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="hidden" name="looking_to_buy" value="0">
                    <input type="checkbox" name="looking_to_buy" value="1"
                           x-model="lookingToBuy"
                           class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <div>
                        <span class="font-medium text-gray-900">I'm looking to buy a pharmacy</span>
                        <p class="text-gray-500 text-sm">Enable to get tailored listings and alerts for pharmacies that match your criteria.</p>
                    </div>
                </label>

                <div class="grid md:grid-cols-2 gap-4 mt-4" x-show="lookingToBuy" x-cloak>
                    <div>
                        <label for="buy_location_preference" class="block text-sm font-medium text-gray-700 mb-1">Preferred Locations</label>
                        <input type="text" name="buy_location_preference" id="buy_location_preference"
                               value="{{ old('buy_location_preference', $user->buy_location_preference) }}"
                               placeholder="e.g. London, South East"
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('buy_location_preference')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="buy_timeframe" class="block text-sm font-medium text-gray-700 mb-1">Timeframe</label>
                        <select name="buy_timeframe" id="buy_timeframe"
                                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="">— Select —</option>
                            @foreach($buyTimeframeOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('buy_timeframe', $user->buy_timeframe?->value) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('buy_timeframe')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Email Preferences --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Email Preferences</h2>
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="hidden" name="newsletter_subscribed" value="0">
                    <input type="checkbox" name="newsletter_subscribed" value="1"
                           {{ old('newsletter_subscribed', $user->newsletter_subscribed) ? 'checked' : '' }}
                           class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <div>
                        <span class="font-medium text-gray-900">Weekly newsletter</span>
                        <p class="text-gray-500 text-sm">Market insights, analysis and new listings delivered every Thursday.</p>
                    </div>
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                    Save Changes
                </button>
            </div>
        </form>

        {{-- Auto-pick the correct default for the job title select, which
             the `selected` shorthand on options doesn't support inside a
             dynamic x-model field. --}}
        <script>
            (function () {
                const sel = document.getElementById('job_title');
                if (sel) {
                    sel.value = @json(old('job_title', $user->job_title?->value));
                    sel.dispatchEvent(new Event('change'));
                }
            })();
        </script>

        {{-- Change Password --}}
        <div class="mt-8 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h2>

            <form action="{{ route('account.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    @error('current_password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" id="password" required
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-black transition">
                        Update Password
                    </button>
                </div>
            </form>

            <p class="text-gray-500 text-xs mt-4">
                Forgot your current password?
                <a href="{{ route('password.request') }}" class="text-green-600 hover:text-green-700 font-medium">Reset it via email →</a>
            </p>
        </div>

        {{-- Danger Zone --}}
        <div class="mt-8 bg-red-50 border border-red-200 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-red-900 mb-2">Delete Account</h2>
            <p class="text-red-700 text-sm mb-4">Once you delete your account, all of your data will be permanently removed. This action cannot be undone.</p>
            <button type="button" class="text-red-600 hover:text-red-800 font-medium text-sm"
                    onclick="alert('Please contact support to delete your account.')">
                Delete my account
            </button>
        </div>
    </div>
</x-layouts.app>
