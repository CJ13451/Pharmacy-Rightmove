<?php

namespace App\Enums;

enum ArticleType: string
{
    case NEWS = 'news';
    case ANALYSIS = 'analysis';
    case GUIDE = 'guide';
    case MARKET_REPORT = 'market_report';
    case OPINION = 'opinion';

    public function label(): string
    {
        return match($this) {
            self::NEWS => 'News',
            self::ANALYSIS => 'Analysis',
            self::GUIDE => 'Guide',
            self::MARKET_REPORT => 'Market Report',
            self::OPINION => 'Opinion',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::NEWS => 'blue',
            self::ANALYSIS => 'purple',
            self::GUIDE => 'green',
            self::MARKET_REPORT => 'orange',
            self::OPINION => 'pink',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
