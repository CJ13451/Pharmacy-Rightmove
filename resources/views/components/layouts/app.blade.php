@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? "{$title} — P3 Pharmacy" : 'P3 Pharmacy — Intelligence. Analysis. Insight.' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="antialiased bg-gray-50 min-h-screen flex flex-col" x-data>
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="text-xl font-bold text-gray-900">p3<span class="text-green-600">pharmacy</span></span>
                    </a>
                </div>

                <!-- Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('news.index') }}" class="text-sm font-medium {{ request()->routeIs('news.*') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">News</a>
                    <a href="{{ route('listings.index') }}" class="text-sm font-medium {{ request()->routeIs('listings.*') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">Pharmacies for Sale</a>
                    <a href="{{ route('training.index') }}" class="text-sm font-medium {{ request()->routeIs('training.*') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">Training</a>
                    <a href="{{ route('suppliers.index') }}" class="text-sm font-medium {{ request()->routeIs('suppliers.*') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">Suppliers</a>
                    <a href="{{ route('resources.index') }}" class="text-sm font-medium {{ request()->routeIs('resources.*') ? 'text-green-600' : 'text-gray-700 hover:text-green-600' }}">Resources</a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                <span class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-xs font-semibold">
                                    {{ auth()->user()->initials }}
                                </span>
                                <span class="hidden sm:inline">{{ auth()->user()->first_name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div 
                                x-show="open" 
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100"
                                style="display: none;"
                            >
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                                <a href="{{ route('account.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Account Settings</a>
                                
                                @if(auth()->user()->canAccessCms())
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Admin Panel</a>
                                @endif

                                @if(auth()->user()->isEstateAgent())
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="{{ route('agent.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Agent Dashboard</a>
                                @endif

                                @if(auth()->user()->isSupplier())
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="{{ route('supplier.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Supplier Dashboard</a>
                                @endif

                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">Sign In</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-green-600 px-4 py-2 rounded-lg hover:bg-green-700">Register</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="$dispatch('toggle-mobile-menu')" class="text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <span>{{ session('info') }}</span>
                <button onclick="this.parentElement.remove()" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-1">
                    <span class="text-lg font-bold text-white">p3<span class="text-green-500">pharmacy</span></span>
                    <p class="mt-2 text-sm">Intelligence. Analysis. Insight.</p>
                    <p class="mt-4 text-sm">The UK's leading resource for pharmacy owners and prospective buyers.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Marketplace</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('listings.index') }}" class="hover:text-white">Pharmacies for Sale</a></li>
                        <li><a href="{{ route('valuations') }}" class="hover:text-white">Valuations</a></li>
                        <li><a href="{{ route('buying-guide') }}" class="hover:text-white">Buying Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('news.index') }}" class="hover:text-white">News & Analysis</a></li>
                        <li><a href="{{ route('training.index') }}" class="hover:text-white">Training</a></li>
                        <li><a href="{{ route('resources.index') }}" class="hover:text-white">Guides & Templates</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Directory</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('suppliers.index') }}" class="hover:text-white">Supplier Directory</a></li>
                        <li><a href="{{ route('suppliers.join') }}" class="hover:text-white">Add Your Business</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between text-sm">
                <span>&copy; {{ date('Y') }} P3 Pharmacy. All rights reserved.</span>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="{{ route('terms') }}" class="hover:text-white">Terms of Service</a>
                    <a href="{{ route('privacy') }}" class="hover:text-white">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
