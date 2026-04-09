<?php

namespace App\Enums;

enum SupplierTier: string
{
    case FREE = 'free';
    case PREMIUM = 'premium';
    case FEATURED = 'featured';

    public function label(): string
    {
        return match($this) {
            self::FREE => 'Free',
            self::PREMIUM => 'Premium',
            self::FEATURED => 'Featured',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::FREE => 'gray',
            self::PREMIUM => 'blue',
            self::FEATURED => 'amber',
        };
    }

    public function features(): array
    {
        return match($this) {
            self::FREE => [
                'Company name and category',
                'Short description (200 chars)',
                'Email and website link',
            ],
            self::PREMIUM => [
                'Everything in Free',
                'Company logo',
                'Photo gallery (up to 5)',
                'Full description',
                'Complete contact details',
                'Social media links',
            ],
            self::FEATURED => [
                'Everything in Premium',
                'Upload resources & guides',
                'Custom branding',
                'Top of category listings',
                'Featured badge',
                'Priority support',
            ],
        };
    }

    public function canUploadLogo(): bool
    {
        return in_array($this, [self::PREMIUM, self::FEATURED]);
    }

    public function canUploadPhotos(): bool
    {
        return in_array($this, [self::PREMIUM, self::FEATURED]);
    }

    public function canUploadResources(): bool
    {
        return $this === self::FEATURED;
    }

    public function canCustomizeBranding(): bool
    {
        return $this === self::FEATURED;
    }

    public function maxPhotos(): int
    {
        return match($this) {
            self::FREE => 0,
            self::PREMIUM => 5,
            self::FEATURED => 10,
        };
    }

    public function maxDescriptionLength(): int
    {
        return match($this) {
            self::FREE => 200,
            self::PREMIUM => 2000,
            self::FEATURED => 5000,
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
