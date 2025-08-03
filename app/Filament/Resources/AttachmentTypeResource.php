<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttachmentTypeResource\Pages;
use App\Models\AttachmentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class AttachmentTypeResource extends Resource
{
    protected static ?string $model = AttachmentType::class;

    protected static ?string $navigationGroup = 'Codifiers';
    protected static ?string $navigationLabel = 'Attachment Types';

    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->nullable()
                    ->maxLength(255),


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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttachmentTypes::route('/'),
            'create' => Pages\CreateAttachmentType::route('/create'),
            'edit' => Pages\EditAttachmentType::route('/{record}/edit'),
        ];
    }
}
