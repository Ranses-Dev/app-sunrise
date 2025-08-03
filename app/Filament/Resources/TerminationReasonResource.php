<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerminationReasonResource\Pages;
use App\Filament\Resources\TerminationReasonResource\RelationManagers;
use App\Models\TerminationReason;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TerminationReasonResource extends Resource
{
    protected static ?string $model = TerminationReason::class;


    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Termination Reason';
    protected static ?string $navigationIcon = 'heroicon-c-arrow-right-end-on-rectangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->string()
                            ->unique(ignoreRecord: true)
                            ->label('Termination Reason Name'),
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->label('Description')
                            ->maxLength(500),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Termination Reason Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTerminationReasons::route('/'),
            'create' => Pages\CreateTerminationReason::route('/create'),
            'edit' => Pages\EditTerminationReason::route('/{record}/edit'),
        ];
    }
}
