<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Filament\Facades\Filament; // Zorg ervoor dat deze regel er is

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Forms\Form $form): Forms\Form // Zorg ervoor dat de type-hints correct zijn
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Naam'),
                
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('E-mail')
                    ->unique(User::class, 'email', ignoreRecord: true),
                
                Forms\Components\Toggle::make('is_admin')
                    ->label('Is Admin')
                    ->required(),
                
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('Wachtwoord')
                    ->rule(Password::default())
                    ->dehydrated(fn ($state) => filled($state)) 
                    ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Naam'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('E-mail'),

                Tables\Columns\BooleanColumn::make('is_admin')
                    ->label('Is Admin'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Aangemaakt op'),
            ])
            ->filters([
                SelectFilter::make('is_admin')
                    ->options([
                        '1' => 'Admin',
                        '0' => 'User',
                    ])
                    ->label('Filter op Admin'),
            ])
            ->actions([
                Action::make('changePassword')
                    ->action(function (User $record, array $data): void {
                        $record->update([
                            'password' => Hash::make($data['new_password']),
                        ]);

                        Filament::notify('success', 'Wachtwoord succesvol gewijzigd.'); 
                    })
                    ->form([
                        Forms\Components\TextInput::make('new_password')
                            ->password()
                            ->label('Nieuw Wachtwoord')
                            ->required()
                            ->rule(Password::default()),
                        
                        Forms\Components\TextInput::make('new_password_confirmation')
                            ->password()
                            ->label('Bevestig Nieuw Wachtwoord')
                            ->same('new_password'),
                    ])
                    ->icon('heroicon-o-key')
                    ->label('Wachtwoord Wijzigen'),
                
                Action::make('delete')
                    ->color('danger')
                    ->action(fn (User $record) => $record->delete())
                    ->icon('heroicon-o-trash')
                    ->label('Verwijderen'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}