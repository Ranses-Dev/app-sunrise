<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Permission Name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('permission')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Permission Name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('associateAllPermissions')
                    ->label('Associate All Permissions')
                    ->icon('heroicon-o-plus')
                    ->action(function ($livewire) {
                        $livewire->ownerRecord->permissions()->sync(Permission::all()->pluck('id')->toArray());
                        Notification::make()
                            ->title('All Permissions associated successfully')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-c-squares-plus')
                    ->visible(fn($livewire) => $livewire->ownerRecord->permissions()->count() < Permission::count())
                    ->requiresConfirmation()
                    ->modalHeading('Associate All Permissions with Role'),
                Action::make('dissociateAllPermissions')
                    ->label('Dissociate All Permissions')
                    ->icon('heroicon-o-x-mark')
                    ->action(function ($livewire) {
                        $livewire->ownerRecord->permissions()->detach();
                        Notification::make()
                            ->title('All Permissions dissociated successfully')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->visible(fn($livewire) => $livewire->ownerRecord->permissions()->count() > 0)
                    ->color('danger')
                    ->modalHeading('Dissociate All Permissions from Role'),
                Action::make('associateRole')
                    ->label('Associate Permission')
                    ->icon('heroicon-o-plus')
                    ->action(function ($livewire, array $data) {
                        $livewire->ownerRecord->permissions()->attach($data['permission_ids']);
                        Notification::make()
                            ->title('Permission(s) associated successfully')
                            ->success()
                            ->send();
                    })
                    ->form([
                        Select::make('permission_ids')
                            ->label('Permission')
                            ->options(function ($livewire) {
                                $assignedPermissionIds = $livewire->ownerRecord->permissions()->pluck('id')->toArray();
                                return Permission::whereNotIn('id', $assignedPermissionIds)
                                    ->pluck('name', 'id');
                            })
                            ->multiple()
                            ->searchable()
                            ->required(),
                    ])
                    ->modalHeading('Associate Permission with Role')
                    ->modalWidth('sm'),
            ])
            ->actions([
                Tables\Actions\Action::make('dissociatePermission')
                    ->label('Dissociate')
                    ->icon('heroicon-o-x-mark')
                    ->action(function ($record, $livewire) {
                        $livewire->ownerRecord->permissions()->detach($record->id);
                        Notification::make()
                            ->title('Permission dissociated successfully')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->bulkActions([]);
    }
}
