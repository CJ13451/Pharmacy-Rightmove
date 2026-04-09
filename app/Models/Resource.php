<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resource extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'slug',
        'status',
        'title',
        'description',
        'type',
        'icon',
        'is_premium',
        'resource_format',
        'file_url',
        'external_url',
        'category',
        'tags',
        'download_count',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_premium' => 'boolean',
        ];
    }

    // ----- Boot -----

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resource) {
            if (empty($resource->slug)) {
                $resource->slug = Str::slug($resource->title) . '-' . Str::random(6);
            }
        });
    }

    // ----- Accessors -----

    public function getTypeIconAttribute(): string
    {
        if ($this->icon) {
            return $this->icon;
        }
        
        return match($this->type) {
            'guide' => '📖',
            'template' => '📝',
            'checklist' => '✅',
            'tool' => '🛠️',
            'report' => '📊',
            'whitepaper' => '📄',
            default => '📋',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'guide' => 'Guide',
            'template' => 'Template',
            'checklist' => 'Checklist',
            'tool' => 'Tool',
            'report' => 'Report',
            'whitepaper' => 'Whitepaper',
            default => 'Resource',
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'buying' => 'Buying a Pharmacy',
            'selling' => 'Selling a Pharmacy',
            'valuation' => 'Valuation',
            'operations' => 'Operations',
            'compliance' => 'Compliance',
            'finance' => 'Finance',
            'hr' => 'HR & Staffing',
            'clinical' => 'Clinical',
            default => ucfirst($this->category),
        };
    }

    public function getUrlAttribute(): ?string
    {
        return match($this->resource_format) {
            'download' => $this->file_url,
            'external_link' => $this->external_url,
            'internal_page' => route('resources.show', $this->slug),
            default => null,
        };
    }

    public function getIsDownloadAttribute(): bool
    {
        return $this->resource_format === 'download';
    }

    public function getIsExternalAttribute(): bool
    {
        return $this->resource_format === 'external_link';
    }

    // ----- Methods -----

    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }

    public function isAccessibleBy(?User $user): bool
    {
        if (!$this->is_premium) {
            return true;
        }
        
        // TODO: Check if user has premium access
        return $user !== null;
    }

    // ----- Scopes -----

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeInCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
