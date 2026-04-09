<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service — P3 Pharmacy</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white">
    <header class="border-b border-gray-200">
        <nav class="max-w-4xl mx-auto px-4 py-4">
            <a href="/" class="text-xl font-bold text-gray-900">p3<span class="text-green-600">pharmacy</span></a>
        </nav>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Terms of Service</h1>
        
        <div class="prose prose-gray max-w-none">
            <p class="text-gray-600 mb-6">Last updated: {{ date('F Y') }}</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">1. Agreement to Terms</h2>
            <p class="text-gray-700 mb-4">By accessing or using P3 Pharmacy, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using or accessing this site.</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">2. Use License</h2>
            <p class="text-gray-700 mb-4">Permission is granted to temporarily access the materials on P3 Pharmacy's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title.</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">3. User Accounts</h2>
            <p class="text-gray-700 mb-4">When you create an account with us, you must provide accurate, complete, and current information. You are responsible for safeguarding the password and for all activities that occur under your account.</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">4. Listings and Content</h2>
            <p class="text-gray-700 mb-4">Property listings and content uploaded by users remain the responsibility of the user. P3 Pharmacy does not verify the accuracy of listing information and is not liable for any inaccuracies.</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">5. Payment Terms</h2>
            <p class="text-gray-700 mb-4">For paid services including listing fees and training courses, payment is processed securely through our payment provider. Refunds are handled on a case-by-case basis.</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">6. Limitation of Liability</h2>
            <p class="text-gray-700 mb-4">P3 Pharmacy shall not be liable for any damages arising from the use or inability to use the materials on this website, even if we have been notified of the possibility of such damages.</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">7. Governing Law</h2>
            <p class="text-gray-700 mb-4">These terms and conditions are governed by and construed in accordance with the laws of England and Wales.</p>

            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">8. Contact Information</h2>
            <p class="text-gray-700 mb-4">If you have any questions about these Terms, please contact us at legal@p3pharmacy.co.uk.</p>
        </div>
    </main>

    <footer class="border-t border-gray-200 mt-12">
        <div class="max-w-4xl mx-auto px-4 py-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} P3 Pharmacy. All rights reserved.
        </div>
    </footer>
</body>
</html>
