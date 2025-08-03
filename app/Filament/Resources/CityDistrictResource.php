<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityDistrictResource\Pages;
use App\Filament\Resources\CityDistrictResource\RelationManagers;
use App\Models\CityDistrict;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityDistrictResource extends Resource
{
    protected static ?string $model = CityDistrict::class;

    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'City Districts';
    protected static ?string $navigationIcon = 'heroicon-c-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('District Name'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCityDistricts::route('/'),
            'create' => Pages\CreateCityDistrict::route('/create'),
            'edit' => Pages\EditCityDistrict::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
