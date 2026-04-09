<?php

namespace App\Enums;

enum Region: string
{
    case LONDON = 'london';
    case SOUTH_EAST = 'south_east';
    case SOUTH_WEST = 'south_west';
    case EAST_OF_ENGLAND = 'east_of_england';
    case WEST_MIDLANDS = 'west_midlands';
    case EAST_MIDLANDS = 'east_midlands';
    case YORKSHIRE = 'yorkshire';
    case NORTH_WEST = 'north_west';
    case NORTH_EAST = 'north_east';
    case WALES = 'wales';
    case SCOTLAND = 'scotland';
    case NORTHERN_IRELAND = 'northern_ireland';

    public function label(): string
    {
        return match($this) {
            self::LONDON => 'London',
            self::SOUTH_EAST => 'South East',
            self::SOUTH_WEST => 'South West',
            self::EAST_OF_ENGLAND => 'East of England',
            self::WEST_MIDLANDS => 'West Midlands',
            self::EAST_MIDLANDS => 'East Midlands',
            self::YORKSHIRE => 'Yorkshire & Humber',
            self::NORTH_WEST => 'North West',
            self::NORTH_EAST => 'North East',
            self::WALES => 'Wales',
            self::SCOTLAND => 'Scotland',
            self::NORTHERN_IRELAND => 'Northern Ireland',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
