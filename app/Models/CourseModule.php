<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class CourseModule extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'course_id',
        'position',
        'title',
        'description',
        'content_type',
        'content_body',
        'video_url',
        'video_provider',
        'scorm_package_url',
        'scorm_package_path',
        'scorm_entry_path',
        'scorm_version',
        'download_url',
        'download_name',
        'duration_minutes',
        'requires_completion',
        'pass_percentage',
    ];

    protected function casts(): array
    {
        return [
            'requires_completion' => 'boolean',
        ];
    }

    // ----- Relationships -----

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(ModuleProgress::class, 'module_id');
    }

    // ----- Accessors -----

    public function getSlugAttribute(): string
    {
        return \Illuminate\Support\Str::slug($this->title);
    }

    public function getFormattedDurationAttribute(): string
    {
        if ($this->duration_minutes < 60) {
            return "{$this->duration_minutes} mins";
        }
        
        $hours = floor($this->duration_minutes / 60);
        $mins = $this->duration_minutes % 60;
        
        return $mins > 0 ? "{$hours}h {$mins}m" : "{$hours}h";
    }

    public function getIsScormAttribute(): bool
    {
        return $this->content_type === 'scorm';
    }

    /**
     * Resolved URL that the SCORM iframe should load. Returns null until the
     * admin has uploaded a package and the observer has extracted it.
     */
    public function getScormEntryUrlAttribute(): ?string
    {
        if (! $this->scorm_package_path || ! $this->scorm_entry_path) {
            return null;
        }

        return Storage::disk('public')->url(
            $this->scorm_package_path.'/'.ltrim($this->scorm_entry_path, '/')
        );
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->content_type === 'video';
    }

    public function getIsTextAttribute(): bool
    {
        return $this->content_type === 'text';
    }

    public function getIsQuizAttribute(): bool
    {
        return $this->content_type === 'quiz';
    }

    // ----- Methods -----

    public function getProgressFor(User $user): ?ModuleProgress
    {
        $enrolment = Enrolment::where('user_id', $user->id)
            ->where('course_id', $this->course_id)
            ->first();
            
        if (!$enrolment) {
            return null;
        }
        
        return $this->progress()
            ->where('enrolment_id', $enrolment->id)
            ->first();
    }

    public function isCompletedBy(User $user): bool
    {
        $progress = $this->getProgressFor($user);
        return $progress?->status === 'completed';
    }

    public function getNextModule(): ?CourseModule
    {
        return CourseModule::where('course_id', $this->course_id)
            ->where('position', '>', $this->position)
            ->orderBy('position')
            ->first();
    }

    public function getPreviousModule(): ?CourseModule
    {
        return CourseModule::where('course_id', $this->course_id)
            ->where('position', '<', $this->position)
            ->orderBy('position', 'desc')
            ->first();
    }
}
