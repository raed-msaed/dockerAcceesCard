<?php

namespace App\Filament\Resources\BadgetResource\Pages;

use App\Filament\Resources\BadgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBadget extends ViewRecord
{
    protected static string $resource = BadgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
