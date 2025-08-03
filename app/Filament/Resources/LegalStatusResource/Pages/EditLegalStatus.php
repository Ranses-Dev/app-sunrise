<?php

namespace App\Filament\Resources\LegalStatusResource\Pages;

use App\Filament\Resources\LegalStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLegalStatus extends EditRecord
{
    protected static string $resource = LegalStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
