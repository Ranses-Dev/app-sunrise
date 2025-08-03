<?php

namespace App\Filament\Resources\CountyDistrictResource\RelationManagers;

use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;

class CitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'cities';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('city')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('associateRole')
                    ->label('Associate City')
                    ->icon('heroicon-o-plus')
                    ->action(function ($livewire, array $data) {
                        $livewire->ownerRecord->cities()->attach($data['city_id']);
                        Notification::make()
                            ->title('City associated successfully')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Select::make('city_id')
                            ->label('City')
                            ->options(function ($livewire) {
                                $assignedCityIds = $livewire->ownerRecord->cities()->pluck('cities.id')->toArray();
                                return City::whereNotIn('id', $assignedCityIds)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->modalHeading('Associate City with County District')
                    ->modalWidth('sm'),
            ])
            ->actions([
                Tables\Actions\Action::make('dissociateCity')
                    ->label('Dissociate')
                    ->icon('heroicon-o-x-mark')
                    ->action(function ($record, $livewire) {
                        $livewire->ownerRecord->cities()->detach($record->id);
                        Notification::make()
                            ->title('City dissociated successfully')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->bulkActions([]);
    }
}
