<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeelthemaResource\Pages;
use App\Filament\Resources\DeelthemaResource\RelationManagers;
use App\Models\Deelthema;
use App\Models\Hoofdthema;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;

class DeelthemaResource extends Resource
{
    protected static ?string $model = Deelthema::class;

    protected static ?string $navigationIcon = 'heroicon-o-window';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('naam')
                    ->required()
                    ->maxLength(255),
                Select::make('hoofdthema_id')
                    ->label('Hoofdthema')
                    ->options(Hoofdthema::all()->pluck('naam', 'id'))
                    ->required(),
                TextInput::make('beschrijving'),
                RichEditor::make('content')
                    ->required()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
                Repeater::make('vragen')
                    ->schema([
                        TextInput::make('vraag')->required(),
                    ]),
                FileUpload::make('media')
                    ->disk('public')
                    ->acceptedFileTypes(['video/mp4'])
                    ->maxSize(102400),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('naam'),
                TextColumn::make('hoofdthema.naam')->label('Hoofdthema'),
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
            'index' => Pages\ListDeelthemas::route('/'),
            'create' => Pages\CreateDeelthema::route('/create'),
            'edit' => Pages\EditDeelthema::route('/{record}/edit'),
        ];
    }
}
