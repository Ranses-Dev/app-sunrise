<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Spatie\Activitylog\Models\Activity as ActivityLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;
    protected static ?string $navigationGroup = 'Admin';
    protected static ?string $navigationLabel = 'Activity Logs';
    protected static ?string $navigationIcon = 'heroicon-m-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('log_name')->label('Log Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('subject_type')->label('Subject Type')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('subject_id')->label('Subject Id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('causer.name')->label('User')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('event')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Date')->date()->sortable(),
                Tables\Columns\TextColumn::make('properties')
                    ->label('Properties')



            ])
            ->filters([
                //
            ])
            ->actions([])
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
            'index' => Pages\ListActivityLogs::route('/')
        ];
    }
}
