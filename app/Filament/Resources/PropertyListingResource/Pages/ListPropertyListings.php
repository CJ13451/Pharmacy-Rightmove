<?php

namespace App\Filament\Resources\PropertyListingResource\Pages;

use App\Filament\Resources\PropertyListingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPropertyListings extends ListRecords
{
    protected static string $resource = PropertyListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
