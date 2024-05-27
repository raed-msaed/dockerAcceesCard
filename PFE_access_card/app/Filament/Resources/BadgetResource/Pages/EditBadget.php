<?php

namespace App\Filament\Resources\BadgetResource\Pages;

use App\Filament\Resources\BadgetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBadget extends EditRecord
{
    protected static string $resource = BadgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
