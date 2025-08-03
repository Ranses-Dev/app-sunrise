<?php

namespace App\Filament\Resources\HouseholdRelationTypeResource\Pages;

use App\Filament\Resources\HouseholdRelationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHouseholdRelationType extends EditRecord
{
    protected static string $resource = HouseholdRelationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
