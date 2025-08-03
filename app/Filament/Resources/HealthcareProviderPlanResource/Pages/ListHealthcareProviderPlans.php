<?php

namespace App\Filament\Resources\HealthcareProviderPlanResource\Pages;

use App\Filament\Resources\HealthcareProviderPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthcareProviderPlans extends ListRecords
{
    protected static string $resource = HealthcareProviderPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
