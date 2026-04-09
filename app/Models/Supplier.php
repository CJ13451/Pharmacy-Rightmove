<?php

namespace App\Models;

use App\Enums\SupplierCategory;
use App\Enums\SupplierTier;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'slug',
        'user_id',
        'status',
        'tier',
        'subscription_status',
        'stripe_subscription_id',
        'stripe_customer_id',
        'subscription_expires_at',
        'name',
        'category',
        'short_description',
        'contact_email',
        'website',
        'logo',
        'long_description',
        'additional_categories',
        'contact_name',
        'contact_phone',
        'address',
        'social_links',
        'photos',
        'custom_branding',
        'views_count',
        'clicks_count',
    ];

    protected function casts(): array
    {
        return [
            'category' => SupplierCategory::class,
            'tier' => SupplierTier::class,
            'additional_categories' => 'array',
            'social_links' => 'array',
            'photos' => 'array',
            'custom_branding' => 'array',
            'subscription_expires_at' => 'datetime',
        ];
    }

    // ----- Boot -----

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            if (empty($supplier->slug)) {
                $supplier->slug = Str::slug($supplier->name) . '-' . Str::random(6);
            }
        });
    }

    // ----- Relationships -----

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(SupplierResource::class);
    }

    // ----- Accessors -----

    public function getDescriptionAttribute(): string
    {
        // Return appropriate description based on tier
        if ($this->tier->canUploadLogo() && $this->long_description) {
            return $this->long_description;
        }
        return $this->short_description;
    }

    public function getAllCategoriesAttribute(): array
    {
        $categories = [$this->category];
        
        if ($this->additional_categories) {
            $categories = array_merge($categories, $this->additional_categories);
        }
        
        return $categories;
    }

    public function getIsFeaturedAttribute(): bool
    {
        return $this->tier === SupplierTier::FEATURED;
    }

    public function getIsPremiumAttribute(): bool
    {
        return in_array($this->tier, [SupplierTier::PREMIUM, SupplierTier::FEATURED]);
    }

    public function getHasActiveSubscriptionAttribute(): bool
    {
        if ($this->tier === SupplierTier::FREE) {
            return true;
        }
        
        return $this->subscription_status === 'active' 
            && (!$this->subscription_expires_at || $this->subscription_expires_at->isFuture());
    }

    // ----- Methods -----

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementClicks(): void
    {
        $this->increment('clicks_count');
    }

    public function canShowLogo(): bool
    {
        return $this->tier->canUploadLogo() && $this->logo;
    }

    public function canShowPhotos(): bool
    {
        return $this->tier->canUploadPhotos() && !empty($this->photos);
    }

    public function canShowResources(): bool
    {
        return $this->tier->canUploadResources() && $this->resources()->exists();
    }

    public function canShowFullContact(): bool
    {
        return $this->is_premium;
    }

    public function upgradeTo(SupplierTier $tier): void
    {
        $this->update(['tier' => $tier]);
        
        // Update user role
        $newRole = match($tier) {
            SupplierTier::FREE => \App\Enums\UserRole::SUPPLIER_FREE,
            SupplierTier::PREMIUM => \App\Enums\UserRole::SUPPLIER_PREMIUM,
            SupplierTier::FEATURED => \App\Enums\UserRole::SUPPLIER_FEATURED,
        };
        
        $this->user->update(['role' => $newRole]);
    }

    // ----- Scopes -----

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('tier', SupplierTier::FEATURED);
    }

    public function scopePremiumOrAbove($query)
    {
        return $query->whereIn('tier', [SupplierTier::PREMIUM, SupplierTier::FEATURED]);
    }

    public function scopeInCategory($query, SupplierCategory $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrderByTier($query)
    {
        // Featured first, then premium, then free
        return $query->orderByRaw("
            CASE tier 
                WHEN 'featured' THEN 1 
                WHEN 'premium' THEN 2 
                WHEN 'free' THEN 3 
            END
        ");
    }
}
