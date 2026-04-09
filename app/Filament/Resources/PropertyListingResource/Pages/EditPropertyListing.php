<?php

namespace App\Filament\Resources\PropertyListingResource\Pages;

use App\Filament\Resources\PropertyListingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyListing extends EditRecord
{
    protected static string $resource = PropertyListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Convert price from pence to pounds for display
        $data['price'] = $data['price'] / 100;
        
        if (isset($data['rent_per_annum'])) {
            $data['rent_per_annum'] = $data['rent_per_annum'] / 100;
        }
        
        if (isset($data['annual_turnover'])) {
            $data['annual_turnover'] = $data['annual_turnover'] / 100;
        }
        
        if (isset($data['annual_gross_profit'])) {
            $data['annual_gross_profit'] = $data['annual_gross_profit'] / 100;
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Convert price from pounds to pence
        $data['price'] = (int) ($data['price'] * 100);
        
        if (isset($data['rent_per_annum'])) {
            $data['rent_per_annum'] = (int) ($data['rent_per_annum'] * 100);
        }
        
        if (isset($data['annual_turnover'])) {
            $data['annual_turnover'] = (int) ($data['annual_turnover'] * 100);
        }
        
        if (isset($data['annual_gross_profit'])) {
            $data['annual_gross_profit'] = (int) ($data['annual_gross_profit'] * 100);
        }
        
        return $data;
    }
}
