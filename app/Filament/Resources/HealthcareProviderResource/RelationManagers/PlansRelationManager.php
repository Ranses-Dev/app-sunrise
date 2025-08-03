<?php

namespace App\Filament\Resources\HealthcareProviderResource\RelationManagers;

use App\Models\HealthcareProviderPlan;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;


class PlansRelationManager extends RelationManager
{
    protected static string $relationship = 'plans';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('plan')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('associatePlan')
                    ->label('Associate Plan')
                    ->icon('heroicon-o-plus')
                    ->action(function ($livewire, array $data) {
                        $livewire->ownerRecord->plans()->attach($data['plan_id']);
                        Notification::make()
                            ->title('Plan associated successfully')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Select::make('plan_id')
                            ->label('Plan')
                            ->options(function ($livewire) {
                                $assignedPlanIds = $livewire->ownerRecord->plans()->pluck('id')->toArray();
                                return HealthcareProviderPlan::whereNotIn('id', $assignedPlanIds)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->modalHeading('Associate Plan with Healthcare Provider')
                    ->modalWidth('sm'),
            ])
            ->actions([
                Tables\Actions\Action::make('dissociatePlan')
                    ->label('Dissociate')
                    ->icon('heroicon-o-x-mark')
                    ->action(function ($record, $livewire) {
                        $livewire->ownerRecord->plans()->detach($record->id);
                        Notification::make()
                            ->title('Plan dissociated successfully')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->bulkActions([]);
    }
}
