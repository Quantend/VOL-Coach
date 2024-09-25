<?php

namespace App\Filament\Resources\UitdagingResource\Pages;

use App\Filament\Resources\UitdagingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUitdagings extends ListRecords
{
    protected static string $resource = UitdagingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
