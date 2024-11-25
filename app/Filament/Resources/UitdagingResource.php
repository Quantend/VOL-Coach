<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UitdagingResource\Pages;
use App\Filament\Resources\UitdagingResource\RelationManagers;
use App\Models\Deelthema;
use App\Models\Uitdaging;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
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

class UitdagingResource extends Resource
{
    protected static ?string $model = Uitdaging::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Contentbeheer';
    protected static ?string $navigationLabel = 'Uitdagingen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Select::make('deelthema_id')
                            ->label('Deelthema')
                            ->options(Deelthema::all()->pluck('naam', 'id'))
                            ->required(),
                        Select::make('niveau')
                            ->required()
                            ->options([
                                'experimenteren' => 'experimenteren',
                                'toepassen' => 'toepassen',
                                'verdiepen' => 'verdiepen',
                            ]),
                        FileUpload::make('validatie')
                            ->label('Validatie formulier (pdf)')
                            ->maxSize(2048)
                            ->preserveFilenames()
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword',]),
                    ]),
                Grid::make(1)
                    ->schema([
                        Repeater::make('opdrachten')
                            ->schema([
                                TextInput::make('opdracht')
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('deelthema.naam')->label('Deelthema'),
                TextColumn::make('niveau')->label('niveau'),
                TextColumn::make('created_at')->label('Created'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListUitdagings::route('/'),
            'create' => Pages\CreateUitdaging::route('/create'),
            'edit' => Pages\EditUitdaging::route('/{record}/edit'),
        ];
    }
}
