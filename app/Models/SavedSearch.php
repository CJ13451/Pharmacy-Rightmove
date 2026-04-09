<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedSearch extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'filters',
        'email_alerts',
        'alert_frequency',
        'last_alerted_at',
    ];

    protected function casts(): array
    {
        return [
            'filters' => 'array',
            'email_alerts' => 'boolean',
            'last_alerted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFiltersSummaryAttribute(): string
    {
        $parts = [];
        
        if (!empty($this->filters['location'])) {
            $parts[] = $this->filters['location'];
        }
        
        if (!empty($this->filters['min_price']) || !empty($this->filters['max_price'])) {
            $min = $this->filters['min_price'] ?? 'Any';
            $max = $this->filters['max_price'] ?? 'Any';
            $parts[] = "£{$min} - £{$max}";
        }
        
        if (!empty($this->filters['region'])) {
            $parts[] = ucfirst(str_replace('_', ' ', $this->filters['region']));
        }
        
        return implode(' • ', $parts) ?: 'All listings';
    }
}
