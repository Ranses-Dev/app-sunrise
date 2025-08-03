<?php

namespace App\Filament\Resources\DeliveryCostResource\Pages;

use App\Filament\Resources\DeliveryCostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryCosts extends ListRecords
{
    protected static string $resource = DeliveryCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
