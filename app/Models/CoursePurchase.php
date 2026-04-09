<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoursePurchase extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'stripe_payment_intent_id',
        'status',
        'purchased_at',
    ];

    protected function casts(): array
    {
        return [
            'purchased_at' => 'datetime',
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

    // ----- Accessors -----

    public function getFormattedAmountAttribute(): string
    {
        return '£' . number_format($this->amount / 100, 2);
    }

    // ----- Methods -----

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'purchased_at' => now(),
        ]);

        // Create enrolment
        Enrolment::create([
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);

        // Increment course enrolments count
        $this->course->increment('enrolments_count');
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    public function refund(): void
    {
        $this->update(['status' => 'refunded']);
    }

    // ----- Scopes -----

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
