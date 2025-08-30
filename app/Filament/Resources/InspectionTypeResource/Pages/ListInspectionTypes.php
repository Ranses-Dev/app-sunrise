<?php

namespace App\Filament\Resources\InspectionTypeResource\Pages;

use App\Filament\Resources\InspectionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInspectionTypes extends ListRecords
{
    protected static string $resource = InspectionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
