<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthcareProviderResource\Pages;
use App\Filament\Resources\HealthcareProviderResource\RelationManagers\PlansRelationManager;
use App\Models\HealthcareProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class HealthcareProviderResource extends Resource
{
    protected static ?string $model = HealthcareProvider::class;

    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Healthcare Provider';
    protected static ?string $navigationIcon = 'heroicon-s-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('plans')
                    ->label('Plans')
                    ->badge()
                    ->getStateUsing(fn($record) => $record->plans->pluck('name')->toArray()),


                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            PlansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHealthcareProviders::route('/'),
            'create' => Pages\CreateHealthcareProvider::route('/create'),
            'edit' => Pages\EditHealthcareProvider::route('/{record}/edit'),
        ];
    }
}
