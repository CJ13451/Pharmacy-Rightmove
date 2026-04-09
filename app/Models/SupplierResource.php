<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierResource extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'supplier_id',
        'title',
        'description',
        'type',
        'file_url',
        'file_type',
        'download_count',
    ];

    // ----- Relationships -----

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // ----- Accessors -----

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'guide' => '📖',
            'brochure' => '📄',
            'case_study' => '📊',
            'video' => '🎬',
            'training' => '🎓',
            default => '📋',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'guide' => 'Guide',
            'brochure' => 'Brochure',
            'case_study' => 'Case Study',
            'video' => 'Video',
            'training' => 'Training Material',
            default => 'Resource',
        };
    }

    // ----- Methods -----

    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }
}
