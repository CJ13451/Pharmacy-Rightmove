<?php

namespace App\Enums;

enum BuyTimeframe: string
{
    case ACTIVELY_LOOKING = 'actively_looking';
    case WITHIN_6_MONTHS = 'within_6_months';
    case WITHIN_12_MONTHS = 'within_12_months';
    case ONE_TO_TWO_YEARS = '1_2_years';
    case RESEARCHING = 'researching';

    public function label(): string
    {
        return match($this) {
            self::ACTIVELY_LOOKING => 'Actively looking now',
            self::WITHIN_6_MONTHS => 'Within 6 months',
            self::WITHIN_12_MONTHS => 'Within 12 months',
            self::ONE_TO_TWO_YEARS => '1-2 years',
            self::RESEARCHING => 'Just researching',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
