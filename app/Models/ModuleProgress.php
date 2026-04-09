<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleProgress extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'module_progress';

    protected $fillable = [
        'enrolment_id',
        'module_id',
        'status',
        'scorm_data',
        'score',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'scorm_data' => 'array',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // ----- Relationships -----

    public function enrolment(): BelongsTo
    {
        return $this->belongsTo(Enrolment::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    // ----- Methods -----

    public function start(): void
    {
        if (!$this->started_at) {
            $this->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
            
            // Start the enrolment if not already started
            $this->enrolment->start();
        }
    }

    public function markAsCompleted(?int $score = null): void
    {
        $this->update([
            'status' => 'completed',
            'score' => $score,
            'completed_at' => now(),
        ]);

        // Update enrolment progress
        $this->enrolment->updateProgress();
    }

    public function updateScormData(array $data): void
    {
        $currentData = $this->scorm_data ?? [];
        $mergedData = array_merge($currentData, $data);
        
        $this->update(['scorm_data' => $mergedData]);

        // Check for completion status in SCORM data
        $completionStatus = $data['cmi.completion_status'] ?? $data['cmi.core.lesson_status'] ?? null;
        
        if (in_array($completionStatus, ['completed', 'passed'])) {
            $score = $data['cmi.score.scaled'] ?? $data['cmi.core.score.raw'] ?? null;
            $this->markAsCompleted($score ? (int) $score : null);
        }
    }

    // ----- Scopes -----

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
}
