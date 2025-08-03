<?php

namespace App\Filament\Resources\DeliveryCostResource\Pages;

use App\Filament\Resources\DeliveryCostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryCost extends EditRecord
{
    protected static string $resource = DeliveryCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
