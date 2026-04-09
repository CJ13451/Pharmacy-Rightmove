<?php

namespace App\Models;

use App\Enums\BuyTimeframe;
use App\Enums\JobTitle;
use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        // Account
        'email',
        'password',
        
        // Personal
        'first_name',
        'last_name',
        'job_title',
        'gphc_number',
        
        // Pharmacy Context
        'currently_own_pharmacy',
        'number_of_pharmacies',
        'current_workplace',
        'looking_to_buy',
        'buy_location_preference',
        'buy_timeframe',
        
        // Role & Preferences
        'role',
        'newsletter_subscribed',
        
        // Stripe
        'stripe_customer_id',

        // Timestamps
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'job_title' => JobTitle::class,
            'buy_timeframe' => BuyTimeframe::class,
            'role' => UserRole::class,
            'currently_own_pharmacy' => 'boolean',
            'looking_to_buy' => 'boolean',
            'newsletter_subscribed' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    // ----- Accessors -----

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getIsPharmacistAttribute(): bool
    {
        return !empty($this->gphc_number);
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(
            substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1)
        );
    }

    // ----- Role Helpers -----

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isEditor(): bool
    {
        return in_array($this->role, [UserRole::EDITOR, UserRole::ADMIN]);
    }

    public function isContentEditor(): bool
    {
        return in_array($this->role, [
            UserRole::CONTENT_EDITOR,
            UserRole::EDITOR,
            UserRole::ADMIN,
        ]);
    }

    public function isEstateAgent(): bool
    {
        return in_array($this->role, [UserRole::ESTATE_AGENT, UserRole::ADMIN]);
    }

    public function isSupplier(): bool
    {
        return $this->role->isSupplier();
    }

    public function supplierTier(): ?string
    {
        return $this->role->supplierTier();
    }

    public function canAccessCms(): bool
    {
        return $this->role->canAccessCms();
    }

    public function canPublishContent(): bool
    {
        return $this->role->canPublishContent();
    }

    public function canManageListings(): bool
    {
        return $this->role->canManageListings();
    }

    // ----- Relationships -----

    public function propertyListings()
    {
        return $this->hasMany(PropertyListing::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function supplierProfile()
    {
        return $this->hasOne(Supplier::class);
    }

    public function savedListings()
    {
        return $this->hasMany(SavedListing::class);
    }

    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function courseEnrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function coursePurchases()
    {
        return $this->hasMany(CoursePurchase::class);
    }

    // ----- Scopes -----

    public function scopeRole($query, UserRole $role)
    {
        return $query->where('role', $role);
    }

    public function scopeLookingToBuy($query)
    {
        return $query->where('looking_to_buy', true);
    }

    public function scopePharmacyOwners($query)
    {
        return $query->where('currently_own_pharmacy', true);
    }

    public function scopePharmacists($query)
    {
        return $query->whereNotNull('gphc_number');
    }
}
