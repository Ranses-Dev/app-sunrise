<?php

namespace App\Filament\Resources\CityDistrictResource\Pages;

use App\Filament\Resources\CityDistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCityDistricts extends ListRecords
{
    protected static string $resource = CityDistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
