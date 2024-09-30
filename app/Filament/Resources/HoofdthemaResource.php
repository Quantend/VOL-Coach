<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HoofdthemaResource\Pages;
use App\Filament\Resources\HoofdthemaResource\RelationManagers;
use App\Models\Hoofdthema;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class HoofdthemaResource extends Resource
{
    protected static ?string $model = Hoofdthema::class;
    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $navigationGroup = 'Contentbeheer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('naam')
                    ->required()
                    ->maxLength(255),
                TextInput::make('media')
                    ->label('Youtube link'),
                Grid::make(1)
                    ->schema([
                        Textarea::make('beschrijving'),
                    ]),
                Grid::make(1)
                    ->schema([
                        TinyEditor::make('content')
                            ->profile('custom')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('naam'),
                TextColumn::make('created_at')->label('Created')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListHoofdthemas::route('/'),
            'create' => Pages\CreateHoofdthema::route('/create'),
            'edit' => Pages\EditHoofdthema::route('/{record}/edit'),
        ];
    }
}
