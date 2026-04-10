<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email — Pharmacy Owner by P3</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="antialiased">
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="/" class="flex justify-center items-center gap-3">
            <img src="{{ asset('images/p3-logo.png') }}" alt="P3" class="h-12 w-auto">
            <span class="text-left leading-tight">
                <span class="block text-xl font-serif font-bold text-gray-900">Pharmacy Owner</span>
                <span class="block text-xs font-medium text-gray-500">by P3</span>
            </span>
        </a>
        <h2 class="mt-6 text-center text-2xl font-bold text-gray-900">Verify your email</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl sm:rounded-xl sm:px-10">
            
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                
                <p class="text-gray-600 mb-6">
                    Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent to <strong>{{ auth()->user()->email }}</strong>.
                </p>

                @if(session('status') === 'verification-link-sent')
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                    @csrf
                    <button 
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        Resend verification email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
