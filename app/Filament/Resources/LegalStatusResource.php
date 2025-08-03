<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegalStatusResource\Pages;
use App\Filament\Resources\LegalStatusResource\RelationManagers;
use App\Models\LegalStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LegalStatusResource extends Resource
{
    protected static ?string $model = LegalStatus::class;

    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Legal Status';
    protected static ?string $navigationIcon = 'heroicon-c-bars-3-bottom-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Legal Status Name'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255)
                    ->label('Description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Legal Status Name')
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
            'index' => Pages\ListLegalStatuses::route('/'),
            'create' => Pages\CreateLegalStatus::route('/create'),
            'edit' => Pages\EditLegalStatus::route('/{record}/edit'),
        ];
    }
}
