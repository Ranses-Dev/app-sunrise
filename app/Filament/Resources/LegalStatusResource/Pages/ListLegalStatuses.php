<?php

namespace App\Filament\Resources\LegalStatusResource\Pages;

use App\Filament\Resources\LegalStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLegalStatuses extends ListRecords
{
    protected static string $resource = LegalStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
