<?php

namespace App\Filament\Resources\HealthcareProviderResource\Pages;

use App\Filament\Resources\HealthcareProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthcareProvider extends EditRecord
{
    protected static string $resource = HealthcareProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
