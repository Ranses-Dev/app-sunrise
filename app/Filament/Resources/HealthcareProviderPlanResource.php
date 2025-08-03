<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthcareProviderPlanResource\Pages;
use App\Filament\Resources\HealthcareProviderPlanResource\RelationManagers;
use App\Models\HealthcareProviderPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HealthcareProviderPlanResource extends Resource
{
    protected static ?string $model = HealthcareProviderPlan::class;
    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Healthcare Provider Plan';
    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHealthcareProviderPlans::route('/'),
            'create' => Pages\CreateHealthcareProviderPlan::route('/create'),
            'edit' => Pages\EditHealthcareProviderPlan::route('/{record}/edit'),
        ];
    }
}
