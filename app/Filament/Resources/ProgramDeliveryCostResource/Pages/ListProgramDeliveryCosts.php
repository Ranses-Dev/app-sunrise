<?php

namespace App\Filament\Resources\ProgramDeliveryCostResource\Pages;

use App\Filament\Resources\ProgramDeliveryCostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramDeliveryCosts extends ListRecords
{
    protected static string $resource = ProgramDeliveryCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
