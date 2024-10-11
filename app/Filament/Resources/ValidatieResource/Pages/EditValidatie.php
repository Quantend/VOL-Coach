<?php

namespace App\Filament\Resources\ValidatieResource\Pages;

use App\Filament\Resources\ValidatieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValidatie extends EditRecord
{
    protected static string $resource = ValidatieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
