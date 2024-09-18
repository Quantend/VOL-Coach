<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HoofdthemaResource\Pages;
use App\Filament\Resources\HoofdthemaResource\RelationManagers;
use App\Models\Hoofdthema;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HoofdthemaResource extends Resource
{
    protected static ?string $model = Hoofdthema::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('naam')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('beschrijving')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        'bulletList',
                        'orderedList',
                        'quote',
                        'codeBlock',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('naam'),
                TextColumn::make('created_at')->label('Created'),
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
