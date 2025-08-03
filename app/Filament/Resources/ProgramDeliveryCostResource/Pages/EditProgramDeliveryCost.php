<?php

namespace App\Filament\Resources\ProgramDeliveryCostResource\Pages;

use App\Filament\Resources\ProgramDeliveryCostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramDeliveryCost extends EditRecord
{
    protected static string $resource = ProgramDeliveryCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
