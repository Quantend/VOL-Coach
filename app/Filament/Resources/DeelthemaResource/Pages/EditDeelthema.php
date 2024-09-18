<?php

namespace App\Filament\Resources\DeelthemaResource\Pages;

use App\Filament\Resources\DeelthemaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeelthema extends EditRecord
{
    protected static string $resource = DeelthemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
