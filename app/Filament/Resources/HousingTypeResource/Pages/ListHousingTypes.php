<?php

namespace App\Filament\Resources\HousingTypeResource\Pages;

use App\Filament\Resources\HousingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHousingTypes extends ListRecords
{
    protected static string $resource = HousingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
