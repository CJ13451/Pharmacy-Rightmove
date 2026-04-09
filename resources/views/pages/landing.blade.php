<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P3 Pharmacy — Intelligence. Analysis. Insight.</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white">
    <!-- Header -->
    <header class="absolute top-0 left-0 right-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-white">p3<span class="text-green-400">pharmacy</span></span>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-white/90 hover:text-white font-medium">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-white text-gray-900 px-5 py-2.5 rounded-lg font-semibold hover:bg-gray-100 transition">Register Free</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Green accent line -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 via-green-400 to-green-500"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="max-w-3xl">
                <p class="text-green-400 font-semibold tracking-wide uppercase mb-4">The UK's Leading Pharmacy Trade Publication</p>
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                    Intelligence.<br>
                    Analysis.<br>
                    <span class="text-green-400">Insight.</span>
                </h1>
                <p class="text-xl text-gray-300 mb-10 max-w-xl">
                    Your essential resource for pharmacy ownership. Market intelligence, pharmacy sales, training, and supplier connections — all in one place.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition shadow-lg shadow-green-500/25">
                        Get Started Free
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center border-2 border-white/30 hover:border-white/50 text-white px-8 py-4 rounded-lg font-semibold text-lg transition">
                        Sign In
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats bar -->
        <div class="absolute bottom-0 left-0 right-0 bg-black/30 backdrop-blur-sm border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">500+</div>
                        <div class="text-gray-400 text-sm">Articles Published</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">150+</div>
                        <div class="text-gray-400 text-sm">Pharmacies Listed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">50+</div>
                        <div class="text-gray-400 text-sm">Training Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">200+</div>
                        <div class="text-gray-400 text-sm">Verified Suppliers</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Everything You Need</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">From market intelligence to pharmacy sales, training to supplier connections — P3 Pharmacy is your complete resource.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">News & Analysis</h3>
                    <p class="text-gray-600">Expert coverage of pharmacy policy, market trends, and business insights to keep you ahead of the curve.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pharmacies for Sale</h3>
                    <p class="text-gray-600">The UK's most comprehensive marketplace for pharmacy businesses. Find your next opportunity or list your pharmacy.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Training & CPD</h3>
                    <p class="text-gray-600">Accredited courses for pharmacy professionals. Build your skills with expert-led training programmes.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Supplier Directory</h3>
                    <p class="text-gray-600">Connect with verified suppliers across wholesalers, PMR systems, accountants, legal services, and more.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-rose-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Guides & Templates</h3>
                    <p class="text-gray-600">Practical resources for pharmacy ownership. Due diligence checklists, valuation guides, and business templates.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-cyan-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Valuations</h3>
                    <p class="text-gray-600">Understand what your pharmacy is worth. Market data and valuation insights to inform your decisions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Ready to get started?</h2>
            <p class="text-xl text-gray-400 mb-10">Join thousands of pharmacy professionals using P3 Pharmacy to stay informed, find opportunities, and grow their businesses.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white px-10 py-4 rounded-lg font-semibold text-lg transition shadow-lg shadow-green-500/25">
                Create Your Free Account
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-950 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <span class="text-xl font-bold text-white">p3<span class="text-green-500">pharmacy</span></span>
                    <p class="text-sm mt-1">Intelligence. Analysis. Insight.</p>
                </div>
                <div class="flex gap-6 text-sm">
                    <a href="{{ route('terms') }}" class="hover:text-white">Terms</a>
                    <a href="{{ route('privacy') }}" class="hover:text-white">Privacy</a>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                &copy; {{ date('Y') }} P3 Pharmacy. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
