<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrolment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'progress_percentage',
        'enrolled_at',
        'started_at',
        'completed_at',
        'last_activity_at',
    ];

    protected function casts(): array
    {
        return [
            'enrolled_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'last_activity_at' => 'datetime',
        ];
    }

    // ----- Relationships -----

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function moduleProgress(): HasMany
    {
        return $this->hasMany(ModuleProgress::class);
    }

    // ----- Methods -----

    public function start(): void
    {
        if (!$this->started_at) {
            $this->update([
                'status' => 'in_progress',
                'started_at' => now(),
                'last_activity_at' => now(),
            ]);
        }
    }

    public function updateProgress(): void
    {
        $totalModules = $this->course->modules()->count();
        
        if ($totalModules === 0) {
            return;
        }

        $completedModules = $this->moduleProgress()
            ->where('status', 'completed')
            ->count();

        $percentage = (int) round(($completedModules / $totalModules) * 100);

        $this->update([
            'progress_percentage' => $percentage,
            'last_activity_at' => now(),
        ]);

        // Mark as completed if all modules done
        if ($percentage === 100 && !$this->completed_at) {
            $this->markAsCompleted();
        }
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);

        // Increment course completions count
        $this->course->increment('completions_count');
    }

    // ----- Scopes -----

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
