<?php

namespace App\Filament\Resources\OpdrachtResource\Pages;

use App\Filament\Resources\OpdrachtResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOpdracht extends EditRecord
{
    protected static string $resource = OpdrachtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
