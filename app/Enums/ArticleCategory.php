<?php

namespace App\Enums;

enum ArticleCategory: string
{
    case POLICY = 'policy';
    case REGULATION = 'regulation';
    case MARKET = 'market';
    case BUSINESS = 'business';
    case CLINICAL = 'clinical';
    case TECHNOLOGY = 'technology';
    case OWNERSHIP = 'ownership';

    public function label(): string
    {
        return match($this) {
            self::POLICY => 'Policy',
            self::REGULATION => 'Regulation',
            self::MARKET => 'Market',
            self::BUSINESS => 'Business',
            self::CLINICAL => 'Clinical',
            self::TECHNOLOGY => 'Technology',
            self::OWNERSHIP => 'Ownership',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
