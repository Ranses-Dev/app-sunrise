<?php

namespace App\Filament\Resources\ProgramBranchResource\Pages;

use App\Filament\Resources\ProgramBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramBranches extends ListRecords
{
    protected static string $resource = ProgramBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
