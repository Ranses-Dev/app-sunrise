<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramsRelationManager extends RelationManager
{
    protected static string $relationship = 'programs';

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
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('associateProgram')
                    ->label('Associate Program')
                    ->icon('heroicon-o-plus')
                    ->action(function ($livewire, array $data) {
                        $livewire->ownerRecord->programs()->attach($data['program_id']);
                        Notification::make()
                            ->title('Program associated successfully')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Forms\Components\Select::make('program_id')
                            ->label('Program')
                            ->options(function ($livewire) {
                                $assignedProgramIds = $livewire->ownerRecord->programs()->pluck('programs.id')->toArray();
                                return \App\Models\Program::whereNotIn('id', $assignedProgramIds)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->modalHeading('Associate Program with User')
                    ->modalWidth('sm'),
            ])
            ->actions([
                Tables\Actions\Action::make('dissociateProgram')
                    ->label('Dissociate')
                    ->icon('heroicon-o-x-mark')
                    ->action(function ($record, $livewire) {
                        $livewire->ownerRecord->programs()->detach($record->id);
                        Notification::make()
                            ->title('Program dissociated successfully')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->bulkActions([]);
    }
}
