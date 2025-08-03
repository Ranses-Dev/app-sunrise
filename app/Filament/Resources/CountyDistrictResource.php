<?php

namespace App\Filament\Resources;


use App\Filament\Resources\CountyDistrictResource\Pages;
use App\Filament\Resources\CountyDistrictResource\RelationManagers;
use App\Filament\Resources\CountyDistrictResource\RelationManagers\CitiesRelationManager;
use App\Models\CountyDistrict;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountyDistrictResource extends Resource
{
    protected static ?string $model = CountyDistrict::class;

    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'County Districts';
    protected static ?string $navigationIcon = 'heroicon-c-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountyDistricts::route('/'),
            'create' => Pages\CreateCountyDistrict::route('/create'),
            'edit' => Pages\EditCountyDistrict::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
