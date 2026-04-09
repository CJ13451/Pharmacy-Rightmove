<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('listing_id')->constrained('property_listings')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            
            // Enquirer details
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            
            // Status
            $table->string('status')->default('new'); // new, read, replied, archived
            
            // Response
            $table->timestamp('replied_at')->nullable();
            $table->text('reply_message')->nullable();
            
            $table->timestamps();
            
            $table->index('listing_id');
            $table->index('user_id');
            $table->index('status');
        });

        Schema::create('saved_listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('listing_id')->constrained('property_listings')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'listing_id']);
        });

        Schema::create('saved_searches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->json('filters');
            $table->boolean('email_alerts')->default(true);
            $table->string('alert_frequency')->default('daily'); // instant, daily, weekly
            $table->timestamp('last_alerted_at')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_searches');
        Schema::dropIfExists('saved_listings');
        Schema::dropIfExists('enquiries');
    }
};
