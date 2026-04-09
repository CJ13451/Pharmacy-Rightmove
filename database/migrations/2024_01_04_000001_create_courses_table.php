<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('status')->default('draft'); // draft, published, archived
            
            // Content
            $table->string('title');
            $table->text('description');
            $table->json('learning_outcomes')->nullable();
            $table->string('thumbnail')->nullable();
            
            // Accreditation
            $table->boolean('cpd_accredited')->default(false);
            $table->unsignedSmallInteger('cpd_points')->nullable();
            $table->string('accreditation_body')->nullable();
            
            // Pricing & Access
            $table->boolean('is_free')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->unsignedInteger('price')->nullable(); // in pence
            
            // Analytics
            $table->unsignedInteger('enrolments_count')->default(0);
            $table->unsignedInteger('completions_count')->default(0);
            $table->decimal('average_rating', 2, 1)->nullable();
            
            $table->timestamps();
            
            $table->index('status');
            $table->index('is_free');
        });

        Schema::create('course_modules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('course_id')->constrained('courses')->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0);
            
            // Content
            $table->string('title');
            $table->text('description')->nullable();
            
            // Content Type
            $table->string('content_type')->default('text'); // text, video, scorm, download, quiz
            
            // Text content
            $table->longText('content_body')->nullable();
            
            // Video
            $table->string('video_url')->nullable();
            $table->string('video_provider')->nullable(); // youtube, vimeo, wistia, uploaded
            
            // SCORM
            $table->string('scorm_package_url')->nullable();
            $table->string('scorm_version')->nullable(); // 1.2, 2004
            
            // Download
            $table->string('download_url')->nullable();
            $table->string('download_name')->nullable();
            
            // Duration
            $table->unsignedSmallInteger('duration_minutes')->default(0);
            
            // Completion
            $table->boolean('requires_completion')->default(true);
            $table->unsignedSmallInteger('pass_percentage')->nullable();
            
            $table->timestamps();
            
            $table->index(['course_id', 'position']);
        });

        Schema::create('course_purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('course_id')->constrained('courses')->cascadeOnDelete();
            
            // Payment
            $table->unsignedInteger('amount'); // in pence
            $table->string('stripe_payment_intent_id');
            $table->string('status')->default('pending'); // pending, completed, refunded, failed
            
            $table->timestamp('purchased_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'course_id']);
        });

        Schema::create('enrolments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('course_id')->constrained('courses')->cascadeOnDelete();
            
            // Progress
            $table->string('status')->default('enrolled'); // enrolled, in_progress, completed
            $table->unsignedSmallInteger('progress_percentage')->default(0);
            
            // Timestamps
            $table->timestamp('enrolled_at');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            
            $table->timestamps();
            
            $table->unique(['user_id', 'course_id']);
        });

        Schema::create('module_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('enrolment_id')->constrained('enrolments')->cascadeOnDelete();
            $table->foreignUuid('module_id')->constrained('course_modules')->cascadeOnDelete();
            
            // Status
            $table->string('status')->default('not_started'); // not_started, in_progress, completed
            
            // SCORM tracking
            $table->json('scorm_data')->nullable();
            $table->unsignedSmallInteger('score')->nullable();
            
            // Timestamps
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            
            $table->unique(['enrolment_id', 'module_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_progress');
        Schema::dropIfExists('enrolments');
        Schema::dropIfExists('course_purchases');
        Schema::dropIfExists('course_modules');
        Schema::dropIfExists('courses');
    }
};
