<?php

namespace App\Filament\Resources\HoofdthemaResource\Pages;

use App\Filament\Resources\HoofdthemaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHoofdthemas extends ListRecords
{
    protected static string $resource = HoofdthemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
