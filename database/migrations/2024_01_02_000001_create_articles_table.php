<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            
            // Status
            $table->string('status')->default('draft');
            
            // Content
            $table->string('title');
            $table->string('excerpt', 500)->nullable();
            $table->longText('content')->nullable();
            $table->string('content_format')->default('blocks'); // blocks, markdown, html
            $table->string('featured_image')->nullable();
            
            // Categorisation
            $table->string('type')->default('news');
            $table->string('category');
            $table->json('tags')->nullable();
            
            // Access Control
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_featured')->default(false);
            
            // Author
            $table->foreignUuid('author_id')->constrained('users')->cascadeOnDelete();
            
            // Engagement
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedSmallInteger('reading_time_minutes')->default(0);
            
            // Publishing
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('type');
            $table->index('category');
            $table->index('is_premium');
            $table->index('is_featured');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
