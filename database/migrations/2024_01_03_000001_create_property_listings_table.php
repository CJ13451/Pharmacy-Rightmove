<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            
            // Status & Visibility
            $table->string('status')->default('draft');
            $table->boolean('featured')->default(false);
            
            // Payment
            $table->string('payment_status')->default('pending'); // pending, paid, refunded
            $table->string('payment_id')->nullable(); // Stripe payment intent ID
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('listing_tier')->default('standard'); // standard, featured, premium
            
            // Basic Info
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('price'); // in pence
            $table->string('price_qualifier')->default('asking'); // asking, guide, offers_over, poa
            
            // Location
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('town');
            $table->string('county')->nullable();
            $table->string('postcode', 10);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('region');
            
            // Property Details
            $table->string('property_type')->default('freehold'); // freehold, leasehold, both
            $table->unsignedSmallInteger('lease_years_remaining')->nullable();
            $table->unsignedBigInteger('rent_per_annum')->nullable(); // in pence
            $table->boolean('has_accommodation')->default(false);
            $table->text('accommodation_details')->nullable();
            
            // Business Details
            $table->unsignedInteger('monthly_items')->nullable();
            $table->unsignedBigInteger('annual_turnover')->nullable(); // in pence
            $table->unsignedBigInteger('annual_gross_profit')->nullable(); // in pence
            $table->unsignedSmallInteger('staff_count')->nullable();
            $table->boolean('nhs_contract')->default(true);
            $table->json('services')->nullable();
            
            // Owner/Agent
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('agent_name');
            $table->string('agent_company')->nullable();
            $table->string('agent_email');
            $table->string('agent_phone');
            
            // Media
            $table->json('images')->nullable();
            $table->string('floor_plan')->nullable();
            $table->json('documents')->nullable();
            
            // Analytics
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('enquiries_count')->default(0);
            $table->unsignedInteger('saves_count')->default(0);
            
            // Timestamps
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('region');
            $table->index('price');
            $table->index('property_type');
            $table->index('featured');
            $table->index(['latitude', 'longitude']);
        });

        // Listing views for analytics
        Schema::create('listing_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('listing_id')->constrained('property_listings')->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('referrer')->nullable();
            $table->timestamp('viewed_at');
            
            $table->index('listing_id');
            $table->index('viewed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_views');
        Schema::dropIfExists('property_listings');
    }
};
