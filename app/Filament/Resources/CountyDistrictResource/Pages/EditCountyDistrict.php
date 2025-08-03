<?php

namespace App\Filament\Resources\CountyDistrictResource\Pages;

use App\Filament\Resources\CountyDistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCountyDistrict extends EditRecord
{
    protected static string $resource = CountyDistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
