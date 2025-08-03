<?php

namespace App\Filament\Resources\HealthcareProviderPlanResource\Pages;

use App\Filament\Resources\HealthcareProviderPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthcareProviderPlan extends EditRecord
{
    protected static string $resource = HealthcareProviderPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
