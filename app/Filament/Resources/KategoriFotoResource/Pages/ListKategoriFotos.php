<?php

namespace App\Filament\Resources\KategoriFotoResource\Pages;

use App\Filament\Resources\KategoriFotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriFotos extends ListRecords
{
    protected static string $resource = KategoriFotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
