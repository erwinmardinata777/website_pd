<?php

namespace App\Filament\Resources\ProfilWebResource\Pages;

use App\Filament\Resources\ProfilWebResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfilWeb extends EditRecord
{
    protected static string $resource = ProfilWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
