<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryCostResource\Pages;
use App\Filament\Resources\DeliveryCostResource\RelationManagers;
use App\Models\DeliveryCost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryCostResource extends Resource
{
    protected static ?string $model = DeliveryCost::class;
    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Delivery Costs';
    protected static ?string $navigationIcon = 'heroicon-m-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->unique(ignoreRecord: true)
                    ->label('Cost (in currency)'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cost')
                    ->label('Cost (in currency)')
                    ->sortable()
                    ->searchable()
                    ->numeric()
                    ->formatStateUsing(fn($state) => number_format($state, 2)),


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
            'index' => Pages\ListDeliveryCosts::route('/'),
            'create' => Pages\CreateDeliveryCost::route('/create'),
            'edit' => Pages\EditDeliveryCost::route('/{record}/edit'),
        ];
    }
}
