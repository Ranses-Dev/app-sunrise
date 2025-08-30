<?php

namespace App\Filament\Resources\HousingTypeResource\Pages;

use App\Filament\Resources\HousingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHousingType extends EditRecord
{
    protected static string $resource = HousingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
