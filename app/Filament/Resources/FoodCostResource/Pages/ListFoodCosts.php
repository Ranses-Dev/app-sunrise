<?php

namespace App\Filament\Resources\FoodCostResource\Pages;

use App\Filament\Resources\FoodCostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFoodCosts extends ListRecords
{
    protected static string $resource = FoodCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
