<?php

namespace App\Filament\Resources\TugasFungsiResource\Pages;

use App\Filament\Resources\TugasFungsiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTugasFungsi extends EditRecord
{
    protected static string $resource = TugasFungsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
