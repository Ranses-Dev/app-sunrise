<?php

namespace App\Filament\Resources\HealthcareProviderResource\Pages;

use App\Filament\Resources\HealthcareProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthcareProviders extends ListRecords
{
    protected static string $resource = HealthcareProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
