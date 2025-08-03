<?php

namespace App\Filament\Resources\TerminationReasonResource\Pages;

use App\Filament\Resources\TerminationReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTerminationReason extends EditRecord
{
    protected static string $resource = TerminationReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
