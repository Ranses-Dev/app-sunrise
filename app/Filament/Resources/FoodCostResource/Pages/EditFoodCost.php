<?php

namespace App\Filament\Resources\FoodCostResource\Pages;

use App\Filament\Resources\FoodCostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFoodCost extends EditRecord
{
    protected static string $resource = FoodCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
