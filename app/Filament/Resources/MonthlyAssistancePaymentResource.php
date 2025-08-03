<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthlyAssistancePaymentResource\Pages;
use App\Filament\Resources\MonthlyAssistancePaymentResource\RelationManagers;
use App\Models\MonthlyAssistancePayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class MonthlyAssistancePaymentResource extends Resource
{
    protected static ?string $model = MonthlyAssistancePayment::class;

    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Monthly Assistance Payment';
    protected static ?string $navigationIcon = 'heroicon-s-document-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Monthly Assistance Payment Name'),
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
                    ->sortable()
                    ->searchable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->label('Description'),

            ])->filters([
                //
            ])->headerActions([
               
            ])->actions([
                //
            ])->bulkActions([
                //
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
            'index' => Pages\ListMonthlyAssistancePayments::route('/'),
            'create' => Pages\CreateMonthlyAssistancePayment::route('/create'),
            'edit' => Pages\EditMonthlyAssistancePayment::route('/{record}/edit'),
        ];
    }
}
