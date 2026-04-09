<?php

namespace App\Enums;

enum UserRole: string
{
    case REGISTERED_USER = 'registered_user';
    case ESTATE_AGENT = 'estate_agent';
    case SUPPLIER_FREE = 'supplier_free';
    case SUPPLIER_PREMIUM = 'supplier_premium';
    case SUPPLIER_FEATURED = 'supplier_featured';
    case CONTENT_EDITOR = 'content_editor';
    case EDITOR = 'editor';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match($this) {
            self::REGISTERED_USER => 'Registered User',
            self::ESTATE_AGENT => 'Estate Agent',
            self::SUPPLIER_FREE => 'Supplier (Free)',
            self::SUPPLIER_PREMIUM => 'Supplier (Premium)',
            self::SUPPLIER_FEATURED => 'Supplier (Featured)',
            self::CONTENT_EDITOR => 'Content Editor',
            self::EDITOR => 'Editor',
            self::ADMIN => 'Administrator',
        };
    }

    public function canAccessCms(): bool
    {
        return in_array($this, [
            self::CONTENT_EDITOR,
            self::EDITOR,
            self::ADMIN,
        ]);
    }

    public function canPublishContent(): bool
    {
        return in_array($this, [
            self::EDITOR,
            self::ADMIN,
        ]);
    }

    public function canManageListings(): bool
    {
        return in_array($this, [
            self::ESTATE_AGENT,
            self::ADMIN,
        ]);
    }

    public function canManageSupplierProfile(): bool
    {
        return in_array($this, [
            self::SUPPLIER_FREE,
            self::SUPPLIER_PREMIUM,
            self::SUPPLIER_FEATURED,
            self::ADMIN,
        ]);
    }

    public function isSupplier(): bool
    {
        return in_array($this, [
            self::SUPPLIER_FREE,
            self::SUPPLIER_PREMIUM,
            self::SUPPLIER_FEATURED,
        ]);
    }

    public function supplierTier(): ?string
    {
        return match($this) {
            self::SUPPLIER_FREE => 'free',
            self::SUPPLIER_PREMIUM => 'premium',
            self::SUPPLIER_FEATURED => 'featured',
            default => null,
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
