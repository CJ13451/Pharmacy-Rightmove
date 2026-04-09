<x-layouts.app title="List Your Business">
    <div class="bg-gray-900 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Join the P3 Pharmacy Supplier Directory</h1>
            <p class="text-xl text-gray-300">Connect with pharmacy professionals across the UK and grow your business.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Pricing Tiers -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Free Tier -->
            <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Free Listing</h3>
                    <div class="text-3xl font-bold text-gray-900">£0</div>
                    <p class="text-gray-500 text-sm">Forever free</p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Basic company profile</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Contact information</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Category listing</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-400">
                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Photo gallery</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-400">
                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Resource downloads</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-400">
                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Priority placement</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}?supplier=1" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-medium transition">
                    Get Started Free
                </a>
            </div>

            <!-- Premium Tier -->
            <div class="bg-white rounded-xl p-8 shadow-lg border-2 border-green-500 relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">POPULAR</span>
                </div>
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Premium</h3>
                    <div class="text-3xl font-bold text-gray-900">£99<span class="text-lg text-gray-500">/month</span></div>
                    <p class="text-gray-500 text-sm">or £990/year (save 17%)</p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Everything in Free</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Extended company description</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Photo gallery (up to 5)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Resource downloads (3 files)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Analytics dashboard</span>
                    </li>
                    <li class="flex items-start gap-2 text-gray-400">
                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Featured placement</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}?supplier=1&tier=premium" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                    Choose Premium
                </a>
            </div>

            <!-- Featured Tier -->
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-8 shadow-sm border border-amber-200">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Featured</h3>
                    <div class="text-3xl font-bold text-gray-900">£199<span class="text-lg text-gray-500">/month</span></div>
                    <p class="text-gray-500 text-sm">or £1,990/year (save 17%)</p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Everything in Premium</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Photo gallery (up to 10)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600">Unlimited resource downloads</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600 font-medium">Featured homepage placement</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600 font-medium">Newsletter spotlight</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-600 font-medium">Social media promotion</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}?supplier=1&tier=featured" class="block w-full text-center bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-lg font-semibold transition">
                    Choose Featured
                </a>
            </div>
        </div>

        <!-- Benefits -->
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Why Join P3 Pharmacy?</h2>
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Targeted Audience</h3>
                    <p class="text-gray-600 text-sm">Reach pharmacy owners, pharmacists, and industry professionals actively seeking suppliers.</p>
                </div>
                <div>
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Detailed Analytics</h3>
                    <p class="text-gray-600 text-sm">Track profile views, website clicks, and resource downloads to measure ROI.</p>
                </div>
                <div>
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Content Marketing</h3>
                    <p class="text-gray-600 text-sm">Share brochures, case studies, and educational resources with potential customers.</p>
                </div>
                <div>
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Brand Visibility</h3>
                    <p class="text-gray-600 text-sm">Featured listings appear prominently on the homepage and in search results.</p>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-8">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <details class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <summary class="font-semibold text-gray-900 cursor-pointer">How do I upgrade my listing?</summary>
                    <p class="text-gray-600 mt-4">You can upgrade your listing at any time from your supplier dashboard. Simply select your preferred tier and complete the payment process.</p>
                </details>
                <details class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <summary class="font-semibold text-gray-900 cursor-pointer">Can I cancel my subscription?</summary>
                    <p class="text-gray-600 mt-4">Yes, you can cancel at any time. Your listing will remain active until the end of your billing period, then revert to the free tier.</p>
                </details>
                <details class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <summary class="font-semibold text-gray-900 cursor-pointer">What file types can I upload?</summary>
                    <p class="text-gray-600 mt-4">We accept PDF, DOC, DOCX, XLS, and XLSX files for resources. Images can be JPG, PNG, or WebP format, up to 5MB each.</p>
                </details>
                <details class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <summary class="font-semibold text-gray-900 cursor-pointer">How long does approval take?</summary>
                    <p class="text-gray-600 mt-4">Most listings are reviewed within 24-48 hours. Featured and premium listings are prioritized for faster approval.</p>
                </details>
            </div>
        </div>
    </div>
</x-layouts.app>
