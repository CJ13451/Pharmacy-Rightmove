<x-layouts.app title="Account Settings">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Account Settings</h1>

        <form action="{{ route('account.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" id="first_name" 
                               value="{{ old('first_name', $user->first_name) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" 
                               value="{{ old('last_name', $user->last_name) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" value="{{ $user->email }}" disabled
                           class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500">
                    <p class="text-gray-500 text-xs mt-1">Contact support to change your email address.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                        <input type="text" value="{{ $user->job_title?->label() }}" disabled
                               class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500">
                    </div>
                    @if($user->gphc_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">GPhC Number</label>
                            <input type="text" value="{{ $user->gphc_number }}" disabled
                                   class="w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Workplace -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Workplace</h2>
                
                <div>
                    <label for="current_workplace" class="block text-sm font-medium text-gray-700 mb-1">Current Workplace</label>
                    <input type="text" name="current_workplace" id="current_workplace" 
                           value="{{ old('current_workplace', $user->current_workplace) }}"
                           placeholder="e.g. Boots, Lloyds, Independent"
                           class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                </div>
            </div>

            <!-- Email Preferences -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Email Preferences</h2>
                
                <div class="space-y-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="newsletter_subscribed" value="1"
                               {{ $user->newsletter_subscribed ? 'checked' : '' }}
                               class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <div>
                            <span class="font-medium text-gray-900">Newsletter</span>
                            <p class="text-gray-500 text-sm">Receive our weekly newsletter with market insights and news.</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Password Change -->
        <div class="mt-8 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h2>
            <p class="text-gray-500 text-sm mb-4">To change your password, use the password reset flow.</p>
            <a href="{{ route('password.request') }}" class="text-green-600 hover:text-green-700 font-medium">
                Reset Password →
            </a>
        </div>

        <!-- Danger Zone -->
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
