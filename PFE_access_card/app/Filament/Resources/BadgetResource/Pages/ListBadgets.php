<?php

namespace App\Filament\Resources\BadgetResource\Pages;

use App\Filament\Resources\BadgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBadgets extends ListRecords
{
    protected static string $resource = BadgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
