<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'slug',
        'status',
        'title',
        'description',
        'learning_outcomes',
        'thumbnail',
        'cpd_accredited',
        'cpd_points',
        'accreditation_body',
        'is_free',
        'is_premium',
        'price',
        'enrolments_count',
        'completions_count',
        'average_rating',
    ];

    protected function casts(): array
    {
        return [
            'learning_outcomes' => 'array',
            'cpd_accredited' => 'boolean',
            'is_free' => 'boolean',
            'is_premium' => 'boolean',
        ];
    }

    // ----- Boot -----

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title) . '-' . Str::random(6);
            }
        });
    }

    // ----- Relationships -----

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('position');
    }

    public function enrolments(): HasMany
    {
        return $this->hasMany(Enrolment::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(CoursePurchase::class);
    }

    // ----- Accessors -----

    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free) {
            return 'Free';
        }
        
        if (!$this->price) {
            return 'Free';
        }
        
        return '£' . number_format($this->price / 100, 2);
    }

    public function getModulesCountAttribute(): int
    {
        return $this->modules()->count();
    }

    public function getTotalDurationMinutesAttribute(): int
    {
        return $this->modules()->sum('duration_minutes');
    }

    public function getFormattedDurationAttribute(): string
    {
        $minutes = $this->total_duration_minutes;
        
        if ($minutes < 60) {
            return "{$minutes} mins";
        }
        
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        
        return $mins > 0 ? "{$hours}h {$mins}m" : "{$hours}h";
    }

    public function getCompletionRateAttribute(): float
    {
        if ($this->enrolments_count === 0) {
            return 0;
        }
        
        return round(($this->completions_count / $this->enrolments_count) * 100, 1);
    }

    // ----- Methods -----

    public function isAccessibleBy(User $user): bool
    {
        // Free courses are accessible to all
        if ($this->is_free) {
            return true;
        }
        
        // Check if user has purchased
        return $this->purchases()
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->exists();
    }

    public function isEnrolled(User $user): bool
    {
        return $this->enrolments()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getProgressFor(User $user): ?int
    {
        $enrolment = $this->enrolments()
            ->where('user_id', $user->id)
            ->first();
            
        return $enrolment?->progress_percentage;
    }

    // ----- Scopes -----

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopePaid($query)
    {
        return $query->where('is_free', false)->whereNotNull('price');
    }
}
