<?php

namespace App\Filament\Resources\ProgramBranchResource\Pages;

use App\Filament\Resources\ProgramBranchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramBranch extends EditRecord
{
    protected static string $resource = ProgramBranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
