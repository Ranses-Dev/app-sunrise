<?php

namespace App\Filament\Resources\IncomeLimitResource\Pages;

use App\Filament\Resources\IncomeLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomeLimit extends EditRecord
{
    protected static string $resource = IncomeLimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
