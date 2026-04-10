<x-layouts.app :title="$resource->title . ' - Premium Content'">
<div class="max-w-7xl mx-auto px-8 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $resource->title }}</h1>

        @if($resource->description)
            <p class="text-gray-600 mb-6">{{ $resource->description }}</p>
        @endif

        <p class="text-gray-700 mb-8">This resource requires an account to access. Please log in or create an account.</p>

        @guest
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">Log In</a>
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-green-600 text-green-600 font-semibold rounded-lg hover:bg-green-50">Create Account</a>
            </div>
        @endguest

        <a href="{{ route('resources.index') }}" class="inline-block mt-6 text-sm text-gray-500 hover:text-gray-700">&larr; Back to Resources</a>
    </div>
</div>
</x-layouts.app>
