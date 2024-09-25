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
use Filament\Notifications\Notification; // Import Notification class

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Forms\Form $form): Forms\Form
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
                        '0' => 'Gebruiker',
                    ])
                    ->label('Filter op role'),
            ])
            ->actions([
                Action::make('changePassword')
                    ->action(function (User $record, array $data): void {
                        $record->update([
                            'password' => Hash::make($data['new_password']),
                        ]);

                        Notification::make()
                            ->title('Succes!')
                            ->success()
                            ->body('Wachtwoord succesvol gewijzigd.')
                            ->send(); 
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
                    ->action(function (User $record) {
                        $record->delete();

                        Notification::make()
                            ->title('Succes!')
                            ->success()
                            ->body('De gebruiker is succesvol verwijderd.')
                            ->send();
                    })
                    ->icon('heroicon-o-trash')
                    ->label('Verwijderen')
                    ->requiresConfirmation()
                    ->modalHeading('Bevestig Verwijdering')
                    ->modalSubheading('Weet je zeker dat je deze gebruiker wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.')
                    ->modalButton('Ja, verwijder deze gebruiker')
                    ->modalWidth('lg'),
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