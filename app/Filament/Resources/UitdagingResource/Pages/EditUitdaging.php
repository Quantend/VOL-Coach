<?php

namespace App\Filament\Resources\UitdagingResource\Pages;

use App\Filament\Resources\UitdagingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUitdaging extends EditRecord
{
    protected static string $resource = UitdagingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
