<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EthnicityResource\Pages;
use App\Filament\Resources\EthnicityResource\RelationManagers;
use App\Models\Ethnicity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EthnicityResource extends Resource
{
    protected static ?string $model = Ethnicity::class;

    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Ethnicity';
    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(255)
                    ->nullable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('notes')
                    ->sortable()
                    ->searchable()
                    ->label('Notes'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEthnicities::route('/'),
            'create' => Pages\CreateEthnicity::route('/create'),
            'edit' => Pages\EditEthnicity::route('/{record}/edit'),
        ];
    }
}
