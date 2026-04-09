<?php

namespace App\Enums;

enum ListingStatus: string
{
    case DRAFT = 'draft';
    case PENDING_REVIEW = 'pending_review';
    case ACTIVE = 'active';
    case UNDER_OFFER = 'under_offer';
    case SOLD = 'sold';
    case WITHDRAWN = 'withdrawn';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::PENDING_REVIEW => 'Pending Review',
            self::ACTIVE => 'Active',
            self::UNDER_OFFER => 'Under Offer',
            self::SOLD => 'Sold',
            self::WITHDRAWN => 'Withdrawn',
            self::EXPIRED => 'Expired',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PENDING_REVIEW => 'yellow',
            self::ACTIVE => 'green',
            self::UNDER_OFFER => 'blue',
            self::SOLD => 'purple',
            self::WITHDRAWN => 'red',
            self::EXPIRED => 'orange',
        };
    }

    public function isPublic(): bool
    {
        return in_array($this, [
            self::ACTIVE,
            self::UNDER_OFFER,
        ]);
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
