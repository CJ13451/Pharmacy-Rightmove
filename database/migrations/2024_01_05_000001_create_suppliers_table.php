<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            
            // Status & Tier
            $table->string('status')->default('pending'); // pending, active, suspended
            $table->string('tier')->default('free'); // free, premium, featured
            
            // Subscription (for paid tiers)
            $table->string('subscription_status')->default('none'); // none, active, past_due, cancelled
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->timestamp('subscription_expires_at')->nullable();
            
            // Basic Info (all tiers)
            $table->string('name');
            $table->string('category');
            $table->string('short_description', 200);
            $table->string('contact_email');
            $table->string('website')->nullable();
            
            // Premium+ fields
            $table->string('logo')->nullable();
            $table->text('long_description')->nullable();
            $table->json('additional_categories')->nullable();
            
            // Premium+ Contact
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('address')->nullable();
            $table->json('social_links')->nullable();
            
            // Premium+ Media
            $table->json('photos')->nullable();
            
            // Featured tier only
            $table->json('custom_branding')->nullable();
            
            // Analytics
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('clicks_count')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('tier');
            $table->index('category');
        });

        Schema::create('supplier_resources', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            
            // Content
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('guide'); // guide, brochure, case_study, video, training, other
            
            // File
            $table->string('file_url');
            $table->string('file_type')->nullable(); // pdf, mp4, etc
            $table->unsignedInteger('download_count')->default(0);
            
            $table->timestamps();
            
            $table->index('supplier_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_resources');
        Schema::dropIfExists('suppliers');
    }
};
