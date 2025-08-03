<?php

namespace App\Filament\Resources\TerminationReasonResource\Pages;

use App\Filament\Resources\TerminationReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTerminationReasons extends ListRecords
{
    protected static string $resource = TerminationReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
