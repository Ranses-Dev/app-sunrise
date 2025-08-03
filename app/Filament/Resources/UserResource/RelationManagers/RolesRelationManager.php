<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('role')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('associateRole')
                    ->label('Associate Role')
                    ->icon('heroicon-o-plus')
                    ->action(function ($livewire, array $data) {
                        $livewire->ownerRecord->roles()->attach($data['role_id']);
                        Notification::make()
                            ->title('Role associated successfully')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Forms\Components\Select::make('role_id')
                            ->label('Role')
                            ->options(function ($livewire) {

                                $assignedRoleIds = $livewire->ownerRecord->roles()->pluck('id')->toArray();

                                // Fetch roles not yet associated
                                return \App\Models\Role::whereNotIn('id', $assignedRoleIds)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->modalHeading('Associate Role with User')
                    ->modalWidth('sm'),
            ])
            ->actions([

                Tables\Actions\Action::make('dissociateRole')
                    ->label('Dissociate')
                    ->icon('heroicon-o-x-mark')
                    ->action(function ($record, $livewire) {
                        $livewire->ownerRecord->roles()->detach($record->id);
                        Notification::make()
                            ->title('Role dissociated successfully')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->bulkActions([]);
    }
}
