<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'listing_id',
        'user_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'replied_at',
        'reply_message',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }

    // ----- Relationships -----

    public function listing(): BelongsTo
    {
        return $this->belongsTo(PropertyListing::class, 'listing_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ----- Methods -----

    public function markAsRead(): void
    {
        if ($this->status === 'new') {
            $this->update(['status' => 'read']);
        }
    }

    public function reply(string $message): void
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now(),
            'reply_message' => $message,
        ]);
    }

    public function archive(): void
    {
        $this->update(['status' => 'archived']);
    }

    // ----- Scopes -----

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeUnread($query)
    {
        return $query->whereIn('status', ['new']);
    }

    public function scopeForListing($query, PropertyListing $listing)
    {
        return $query->where('listing_id', $listing->id);
    }
}
