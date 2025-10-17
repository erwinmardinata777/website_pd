<?php

namespace App\Filament\Resources\LinkTerkaitResource\Pages;

use App\Filament\Resources\LinkTerkaitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLinkTerkaits extends ListRecords
{
    protected static string $resource = LinkTerkaitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
