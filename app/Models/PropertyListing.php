<?php

namespace App\Models;

use App\Enums\ListingStatus;
use App\Enums\Region;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PropertyListing extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'slug',
        'status',
        'featured',
        'payment_status',
        'payment_id',
        'paid_at',
        'expires_at',
        'listing_tier',
        'title',
        'description',
        'price',
        'price_qualifier',
        'address_line_1',
        'address_line_2',
        'town',
        'county',
        'postcode',
        'latitude',
        'longitude',
        'region',
        'property_type',
        'lease_years_remaining',
        'rent_per_annum',
        'has_accommodation',
        'accommodation_details',
        'monthly_items',
        'annual_turnover',
        'annual_gross_profit',
        'staff_count',
        'nhs_contract',
        'services',
        'user_id',
        'agent_name',
        'agent_company',
        'agent_email',
        'agent_phone',
        'images',
        'floor_plan',
        'documents',
        'views_count',
        'enquiries_count',
        'saves_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ListingStatus::class,
            'region' => Region::class,
            'featured' => 'boolean',
            'has_accommodation' => 'boolean',
            'nhs_contract' => 'boolean',
            'services' => 'array',
            'images' => 'array',
            'documents' => 'array',
            'paid_at' => 'datetime',
            'expires_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    // ----- Boot -----

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($listing) {
            if (empty($listing->slug)) {
                $listing->slug = Str::slug($listing->title) . '-' . Str::random(6);
            }
        });
    }

    // ----- Relationships -----

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'listing_id');
    }

    public function savedByUsers(): HasMany
    {
        return $this->hasMany(SavedListing::class, 'listing_id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(ListingView::class, 'listing_id');
    }

    // ----- Accessors -----

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_qualifier === 'poa') {
            return 'POA';
        }

        $formatted = '£' . number_format($this->price / 100);
        
        return match($this->price_qualifier) {
            'guide' => "Guide: {$formatted}",
            'offers_over' => "Offers over {$formatted}",
            default => $formatted,
        };
    }

    public function getFormattedTurnoverAttribute(): ?string
    {
        if (!$this->annual_turnover) return null;
        return '£' . number_format($this->annual_turnover / 100);
    }

    public function getFormattedGrossProfitAttribute(): ?string
    {
        if (!$this->annual_gross_profit) return null;
        return '£' . number_format($this->annual_gross_profit / 100);
    }

    public function getFormattedRentAttribute(): ?string
    {
        if (!$this->rent_per_annum) return null;
        return '£' . number_format($this->rent_per_annum / 100) . ' pa';
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->town,
            $this->county,
            $this->postcode,
        ]);
        return implode(', ', $parts);
    }

    public function getLocationAttribute(): string
    {
        return "{$this->town}, {$this->postcode}";
    }

    public function getPrimaryImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    // ----- Methods -----

    public function incrementViews(?User $user = null): void
    {
        $this->increment('views_count');

        // Log detailed view
        $this->views()->create([
            'user_id' => $user?->id,
            'referrer' => request()->header('referer'),
            'viewed_at' => now(),
        ]);
    }

    public function markAsSold(): void
    {
        $this->update(['status' => ListingStatus::SOLD]);
    }

    public function markAsUnderOffer(): void
    {
        $this->update(['status' => ListingStatus::UNDER_OFFER]);
    }

    public function withdraw(): void
    {
        $this->update(['status' => ListingStatus::WITHDRAWN]);
    }

    // ----- Scopes -----

    public function scopeActive($query)
    {
        return $query->where('status', ListingStatus::ACTIVE)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopePublic($query)
    {
        return $query->whereIn('status', [
            ListingStatus::ACTIVE,
            ListingStatus::UNDER_OFFER,
        ]);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInRegion($query, Region $region)
    {
        return $query->where('region', $region);
    }

    public function scopePriceRange($query, ?int $min = null, ?int $max = null)
    {
        if ($min) {
            $query->where('price', '>=', $min * 100);
        }
        if ($max) {
            $query->where('price', '<=', $max * 100);
        }
        return $query;
    }

    public function scopePropertyType($query, string $type)
    {
        return $query->where('property_type', $type);
    }

    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeNearby($query, float $lat, float $lng, int $radiusMiles = 25)
    {
        $radiusKm = $radiusMiles * 1.60934;
        
        return $query->selectRaw("
            *, 
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ", [$lat, $lng, $lat])
        ->having('distance', '<=', $radiusKm)
        ->orderBy('distance');
    }
}
