<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeLimitResource\Pages;
use App\Filament\Resources\IncomeLimitResource\RelationManagers;
use App\Models\IncomeLimit;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class IncomeLimitResource extends Resource
{
    protected static ?string $model = IncomeLimit::class;
    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Income Limit';
    protected static ?string $navigationIcon = 'heroicon-m-receipt-percent';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('percentage_category')
                            ->required()
                            ->integer()
                            ->minValue(1)
                            ->label('Percentage Category'),
                        Forms\Components\TextInput::make('household_size')
                            ->required()
                            ->integer()
                            ->label('Household Size')
                            ->rule(fn(Get $get, $record): Closure => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                                $exists = DB::table('income_limits')
                                    ->where('percentage_category', $get('percentage_category'))
                                    ->where('household_size', $value)
                                    ->when($record, function ($query) use ($record) {
                                        $query->where('id', '!=', $record->id);
                                    })
                                    ->exists();
                                if ($exists) {
                                    $fail("A record with this percentage category and household size already exists.");
                                }
                            }),
                        Forms\Components\TextInput::make('income_limit')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->label('Income Limit'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('percentage_category')
                    ->label('Percentage Category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('household_size')
                    ->label('Household Size')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('income_limit')
                    ->label('Income Limit')
                    ->sortable()
                    ->searchable(),
            ])->filters([
                SelectFilter::make('percentage_category')
                    ->options(IncomeLimit::all()->pluck('percentage_category', 'percentage_category'))
                    ->multiple()
                    ->placeholder('Select Percentage Category'),
                SelectFilter::make('household_size')
                    ->options(IncomeLimit::all()->pluck('household_size', 'household_size'))
                    ->multiple()
                    ->placeholder('Select Household Size'),
            ])->headerActions([
               

            ])->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])->bulkActions([]);
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
            'index' => Pages\ListIncomeLimits::route('/'),
            'create' => Pages\CreateIncomeLimit::route('/create'),
            'edit' => Pages\EditIncomeLimit::route('/{record}/edit'),
        ];
    }
}
