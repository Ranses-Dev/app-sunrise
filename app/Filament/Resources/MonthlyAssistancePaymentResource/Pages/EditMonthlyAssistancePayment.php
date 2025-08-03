<?php

namespace App\Filament\Resources\MonthlyAssistancePaymentResource\Pages;

use App\Filament\Resources\MonthlyAssistancePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonthlyAssistancePayment extends EditRecord
{
    protected static string $resource = MonthlyAssistancePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
