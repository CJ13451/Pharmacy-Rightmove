<?php

namespace App\Enums;

enum SupplierCategory: string
{
    case WHOLESALER = 'wholesaler';
    case PMR_SYSTEM = 'pmr_system';
    case BUYING_GROUP = 'buying_group';
    case EPOS = 'epos';
    case ACCOUNTANT = 'accountant';
    case LEGAL = 'legal';
    case INSURANCE = 'insurance';
    case FITOUT = 'fitout';
    case TRAINING = 'training';
    case RECRUITMENT = 'recruitment';
    case CONSULTING = 'consulting';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::WHOLESALER => 'Wholesaler',
            self::PMR_SYSTEM => 'PMR System',
            self::BUYING_GROUP => 'Buying Group',
            self::EPOS => 'EPOS / Till System',
            self::ACCOUNTANT => 'Accountant',
            self::LEGAL => 'Legal Services',
            self::INSURANCE => 'Insurance',
            self::FITOUT => 'Pharmacy Fitout',
            self::TRAINING => 'Training Provider',
            self::RECRUITMENT => 'Recruitment',
            self::CONSULTING => 'Consulting',
            self::OTHER => 'Other',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::WHOLESALER => '📦',
            self::PMR_SYSTEM => '💻',
            self::BUYING_GROUP => '🤝',
            self::EPOS => '🖥️',
            self::ACCOUNTANT => '📊',
            self::LEGAL => '⚖️',
            self::INSURANCE => '🛡️',
            self::FITOUT => '🏗️',
            self::TRAINING => '📚',
            self::RECRUITMENT => '👥',
            self::CONSULTING => '💼',
            self::OTHER => '📋',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
