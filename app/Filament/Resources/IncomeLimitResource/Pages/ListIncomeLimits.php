<?php

namespace App\Filament\Resources\IncomeLimitResource\Pages;

use App\Filament\Resources\IncomeLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomeLimits extends ListRecords
{
    protected static string $resource = IncomeLimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
