<?php

namespace App\Filament\Resources\CountyDistrictResource\Pages;

use App\Filament\Resources\CountyDistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCountyDistricts extends ListRecords
{
    protected static string $resource = CountyDistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
