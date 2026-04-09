<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            
            // Personal Info
            $table->string('first_name');
            $table->string('last_name');
            $table->string('job_title'); // enum via cast
            $table->string('gphc_number', 7)->nullable();
            
            // Pharmacy Context
            $table->boolean('currently_own_pharmacy')->default(false);
            $table->unsignedSmallInteger('number_of_pharmacies')->nullable();
            $table->string('current_workplace')->nullable();
            $table->boolean('looking_to_buy')->default(false);
            $table->string('buy_location_preference')->nullable();
            $table->string('buy_timeframe')->nullable(); // enum via cast
            
            // Role & Access
            $table->string('role')->default('registered_user'); // enum via cast
            
            // Stripe
            $table->string('stripe_customer_id')->nullable()->index();
            
            // Preferences
            $table->boolean('newsletter_subscribed')->default(true);
            
            // Timestamps
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('role');
            $table->index('job_title');
            $table->index('looking_to_buy');
            $table->index('currently_own_pharmacy');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
