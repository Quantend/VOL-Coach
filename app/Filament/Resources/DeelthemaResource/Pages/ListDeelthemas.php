<?php

namespace App\Filament\Resources\DeelthemaResource\Pages;

use App\Filament\Resources\DeelthemaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeelthemas extends ListRecords
{
    protected static string $resource = DeelthemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
