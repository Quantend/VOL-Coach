<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeelthemaResource\Pages;
use App\Filament\Resources\DeelthemaResource\RelationManagers;
use App\Models\Deelthema;
use App\Models\Hoofdthema;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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

class DeelthemaResource extends Resource
{
    protected static ?string $model = Deelthema::class;
    protected static ?string $navigationIcon = 'heroicon-o-window';
    protected static ?string $navigationGroup = 'Contentbeheer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        TextInput::make('naam')
                            ->required()
                            ->maxLength(255),
                        Select::make('hoofdthema_id')
                            ->label('Hoofdthema')
                            ->options(Hoofdthema::all()->pluck('naam', 'id'))
                            ->required(),
                        TextInput::make('media')
                            ->label('Youtube link')
                    ]),
                TextArea::make('beschrijving')
                    ->maxLength(80)
                    ->label('Korte beschrijving (maximaal 80 karakters)'),
                Repeater::make('vragen')
                    ->schema([
                        TextInput::make('vraag')
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
                TextColumn::make('hoofdthema.naam')->label('Hoofdthema'),
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
            'index' => Pages\ListDeelthemas::route('/'),
            'create' => Pages\CreateDeelthema::route('/create'),
            'edit' => Pages\EditDeelthema::route('/{record}/edit'),
        ];
    }
}
