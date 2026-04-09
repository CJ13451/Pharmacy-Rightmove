<?php

namespace App\Enums;

enum JobTitle: string
{
    case PHARMACIST = 'pharmacist';
    case PHARMACY_TECHNICIAN = 'pharmacy_technician';
    case PHARMACY_OWNER = 'pharmacy_owner';
    case PHARMACY_MANAGER = 'pharmacy_manager';
    case LOCUM_PHARMACIST = 'locum_pharmacist';
    case PRE_REG_PHARMACIST = 'pre_reg_pharmacist';
    case ESTATE_AGENT = 'estate_agent';
    case SUPPLIER_VENDOR = 'supplier_vendor';
    case CONSULTANT = 'consultant';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::PHARMACIST => 'Pharmacist',
            self::PHARMACY_TECHNICIAN => 'Pharmacy Technician',
            self::PHARMACY_OWNER => 'Pharmacy Owner',
            self::PHARMACY_MANAGER => 'Pharmacy Manager',
            self::LOCUM_PHARMACIST => 'Locum Pharmacist',
            self::PRE_REG_PHARMACIST => 'Pre-registration Pharmacist',
            self::ESTATE_AGENT => 'Estate Agent',
            self::SUPPLIER_VENDOR => 'Supplier / Vendor',
            self::CONSULTANT => 'Consultant',
            self::OTHER => 'Other',
        };
    }

    public function requiresGphc(): bool
    {
        return in_array($this, [
            self::PHARMACIST,
            self::PHARMACY_OWNER,
            self::PHARMACY_MANAGER,
            self::LOCUM_PHARMACIST,
            self::PRE_REG_PHARMACIST,
        ]);
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($case) => [$case->value => $case->label()]
        )->toArray();
    }
}
