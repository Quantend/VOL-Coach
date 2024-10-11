<?php

namespace App\Filament\Resources\ValidatieResource\Pages;

use App\Filament\Resources\ValidatieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValidaties extends ListRecords
{
    protected static string $resource = ValidatieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
