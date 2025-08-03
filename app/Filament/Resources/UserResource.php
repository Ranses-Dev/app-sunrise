<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Actions\ResetUserTwoFactorAuthentication;
use App\Filament\Resources\UserResource\RelationManagers\ProgramsRelationManager;
use App\Repositories\UserRepositoryInterface;
use Filament\Notifications\Notification;
use App\Jobs\SendRecoveryCodesMail;

class UserResource extends Resource
{
    protected static ?string $navigationGroup = 'Admin';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->unique(
                        ignoreRecord: true
                    ),
                TextInput::make('email')->email()->required()->unique(
                    ignoreRecord: true
                ),
                TextInput::make('password')
                    ->password()
                    ->confirmed()
                    ->required(fn($record): bool => $record === null),
                TextInput::make('password_confirmation')->password()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('Email'),
            ])->filters([
                //
            ])->headerActions([])->actions([
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
                Tables\Actions\Action::make('Send Recovery Codes')
                    ->action(function (User $record) {
                        SendRecoveryCodesMail::dispatch($record);
                        Notification::make()
                            ->title('Recovery Codes Sent')
                            ->body('The recovery codes have been sent to ' . $record->email)
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->visible(fn(User $record) => $record->two_factor_secret_app !== null || $record->two_factor_secret !== null),
                Tables\Actions\Action::make('Reset Two-Factor Authentication')
                    ->action(function (User $record) {
                        $userRepository = app(UserRepositoryInterface::class);
                        $action = new ResetUserTwoFactorAuthentication($userRepository, $record->id);
                        $action->reset($record);
                        Notification::make()
                            ->title('Two-Factor Authentication Reset')
                            ->body('The two-factor authentication for ' . $record->name . ' has been reset.')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-key')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(User $record) => $record->two_factor_secret_app !== null || $record->two_factor_secret !== null)
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
            RolesRelationManager::class,
            ProgramsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
