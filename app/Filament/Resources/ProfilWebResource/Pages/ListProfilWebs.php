<?php

namespace App\Filament\Resources\ProfilWebResource\Pages;

use App\Filament\Resources\ProfilWebResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilWebs extends ListRecords
{
    protected static string $resource = ProfilWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
