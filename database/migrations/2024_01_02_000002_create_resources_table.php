<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('status')->default('draft'); // draft, published, archived
            
            // Content
            $table->string('title');
            $table->text('description');
            $table->string('type'); // guide, template, checklist, tool, report, whitepaper
            $table->string('icon')->nullable();
            
            // Access Control
            $table->boolean('is_premium')->default(false);
            
            // File/Link
            $table->string('resource_format'); // download, external_link, internal_page
            $table->string('file_url')->nullable();
            $table->string('external_url')->nullable();
            
            // Categorisation
            $table->string('category'); // buying, selling, valuation, operations, compliance, finance, hr, clinical
            $table->json('tags')->nullable();
            
            // Analytics
            $table->unsignedInteger('download_count')->default(0);
            
            $table->timestamps();
            
            $table->index('status');
            $table->index('type');
            $table->index('category');
            $table->index('is_premium');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
