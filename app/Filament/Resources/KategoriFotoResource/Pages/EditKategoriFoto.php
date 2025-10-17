<?php

namespace App\Filament\Resources\KategoriFotoResource\Pages;

use App\Filament\Resources\KategoriFotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriFoto extends EditRecord
{
    protected static string $resource = KategoriFotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
