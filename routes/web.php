<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StripeWebhookController;
use App\Livewire\Auth\RegistrationWizard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Stripe Webhook (No Auth, No CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

// Temporary seed route
Route::get('/seed-db', function () {
    \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
    \App\Models\User::truncate();
    \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');

    // Create admin directly with DB insert to avoid any model interference
    \Illuminate\Support\Facades\DB::table('users')->insert([
        'id' => \Illuminate\Support\Str::uuid()->toString(),
        'email' => 'admin@p3pharmacy.co.uk',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'email_verified_at' => now(),
        'first_name' => 'Admin',
        'last_name' => 'User',
        'job_title' => 'pharmacy_owner',
        'role' => 'admin',
        'currently_own_pharmacy' => false,
        'looking_to_buy' => false,
        'newsletter_subscribed' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $user = \App\Models\User::where('email', 'admin@p3pharmacy.co.uk')->first();
    $hash = $user->password;
    $valid = \Illuminate\Support\Facades\Hash::check('password', $hash);

    return "Done. Hash starts with: " . substr($hash, 0, 7) . " | Verify: " . ($valid ? 'PASS' : 'FAIL') . " | Length: " . strlen($hash);
});

/*
|--------------------------------------------------------------------------
| Public Routes (No Auth Required)
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [HomeController::class, 'landing'])->name('landing');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', RegistrationWizard::class)->name('register');
    
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Email Verification
Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Static Pages (Public)
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Login Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', LogoutController::class)->name('logout');
    
    // Email Verification Notice
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    /*
    |--------------------------------------------------------------------------
    | Verified User Routes
    |--------------------------------------------------------------------------
    */
    
    Route::middleware(['verified'])->group(function () {
        
        // Home (authenticated)
        Route::get('/home', [HomeController::class, 'home'])->name('home');
        
        // User Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Account Settings
        Route::get('/account', [DashboardController::class, 'account'])->name('account.settings');
        Route::put('/account', [DashboardController::class, 'updateAccount'])->name('account.update');
        Route::get('/account/purchases', [DashboardController::class, 'purchases'])->name('account.purchases');
        
        // News & Articles
        Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
        Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
        
        // Pharmacy Listings
        Route::get('/pharmacies-for-sale', [\App\Http\Controllers\ListingController::class, 'index'])->name('listings.index');
        Route::get('/pharmacies-for-sale/{slug}', [\App\Http\Controllers\ListingController::class, 'show'])->name('listings.show');
        Route::post('/pharmacies-for-sale/{slug}/enquire', [\App\Http\Controllers\ListingController::class, 'enquire'])->name('listings.enquire');
        Route::post('/pharmacies-for-sale/{slug}/save', [\App\Http\Controllers\ListingController::class, 'toggleSave'])->name('listings.save');
        
        // Training
        Route::get('/training', [\App\Http\Controllers\TrainingController::class, 'index'])->name('training.index');
        Route::get('/training/{slug}', [\App\Http\Controllers\TrainingController::class, 'show'])->name('training.show');
        Route::post('/training/{slug}/enrol', [\App\Http\Controllers\TrainingController::class, 'enrol'])->name('training.enrol');
        Route::get('/training/{slug}/purchase', [\App\Http\Controllers\TrainingController::class, 'purchase'])->name('training.purchase');
        Route::get('/training/{slug}/purchase-success', [\App\Http\Controllers\TrainingController::class, 'purchaseSuccess'])->name('training.purchase-success');
        Route::get('/training/{course}/{module}', [\App\Http\Controllers\TrainingController::class, 'module'])->name('training.module');
        Route::post('/training/{course}/{module}/complete', [\App\Http\Controllers\TrainingController::class, 'completeModule'])->name('training.complete-module');
        Route::post('/training/{course}/{module}/scorm-commit', [\App\Http\Controllers\TrainingController::class, 'scormCommit'])->name('training.scorm-commit');
        
        // Suppliers
        Route::get('/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/suppliers/join', [\App\Http\Controllers\SupplierController::class, 'join'])->name('suppliers.join');
        Route::get('/suppliers/{slug}', [\App\Http\Controllers\SupplierController::class, 'show'])->name('suppliers.show');
        Route::post('/suppliers/{slug}/track-click', [\App\Http\Controllers\SupplierController::class, 'trackClick'])->name('suppliers.track-click');
        
        // Listings additional
        Route::post('/pharmacies-for-sale/{slug}/toggle-save', [\App\Http\Controllers\ListingController::class, 'toggleSave'])->name('listings.toggle-save');
        
        // Resources
        Route::get('/resources', [\App\Http\Controllers\ResourceController::class, 'index'])->name('resources.index');
        Route::get('/resources/{slug}', [\App\Http\Controllers\ResourceController::class, 'show'])->name('resources.show');
        Route::get('/resources/{slug}/download', [\App\Http\Controllers\ResourceController::class, 'download'])->name('resources.download');
        
        // Tools
        Route::get('/valuations', [\App\Http\Controllers\ToolController::class, 'valuations'])->name('valuations');
        Route::get('/buying-guide', [\App\Http\Controllers\ToolController::class, 'buyingGuide'])->name('buying-guide');
        
        // Saved Searches
        Route::get('/saved-searches', [\App\Http\Controllers\SavedSearchController::class, 'index'])->name('saved-searches.index');
        Route::post('/saved-searches', [\App\Http\Controllers\SavedSearchController::class, 'store'])->name('saved-searches.store');
        Route::patch('/saved-searches/{id}/toggle-alerts', [\App\Http\Controllers\SavedSearchController::class, 'toggleAlerts'])->name('saved-searches.toggle-alerts');
        Route::delete('/saved-searches/{id}', [\App\Http\Controllers\SavedSearchController::class, 'destroy'])->name('saved-searches.destroy');
        
    });
});

/*
|--------------------------------------------------------------------------
| Estate Agent Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'can:manage-listings'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Agent\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/listings', [\App\Http\Controllers\Agent\ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/new', [\App\Http\Controllers\Agent\ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [\App\Http\Controllers\Agent\ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{id}/edit', [\App\Http\Controllers\Agent\ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{id}', [\App\Http\Controllers\Agent\ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{id}', [\App\Http\Controllers\Agent\ListingController::class, 'destroy'])->name('listings.destroy');
    Route::get('/listings/{id}/analytics', [\App\Http\Controllers\Agent\ListingController::class, 'analytics'])->name('listings.analytics');
    Route::get('/listings/{id}/payment-success', [\App\Http\Controllers\Agent\ListingController::class, 'paymentSuccess'])->name('listings.payment-success');
    Route::get('/enquiries', [\App\Http\Controllers\Agent\EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/{id}', [\App\Http\Controllers\Agent\EnquiryController::class, 'show'])->name('enquiries.show');
    Route::post('/enquiries/{id}/reply', [\App\Http\Controllers\Agent\EnquiryController::class, 'reply'])->name('enquiries.reply');
    Route::patch('/enquiries/{id}/archive', [\App\Http\Controllers\Agent\EnquiryController::class, 'archive'])->name('enquiries.archive');
});

/*
|--------------------------------------------------------------------------
| Supplier Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'can:manage-supplier-profile'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Supplier\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Supplier\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Supplier\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/resources', [\App\Http\Controllers\Supplier\ResourceController::class, 'index'])->name('resources.index');
    Route::post('/resources', [\App\Http\Controllers\Supplier\ResourceController::class, 'store'])->name('resources.store');
    Route::delete('/resources/{id}', [\App\Http\Controllers\Supplier\ResourceController::class, 'destroy'])->name('resources.destroy');
    Route::get('/subscription', [\App\Http\Controllers\Supplier\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/upgrade', [\App\Http\Controllers\Supplier\SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
    Route::get('/subscription/success', [\App\Http\Controllers\Supplier\SubscriptionController::class, 'success'])->name('subscription.success');
    Route::post('/subscription/cancel', [\App\Http\Controllers\Supplier\SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});
