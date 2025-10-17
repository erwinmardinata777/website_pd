<?php

namespace App\Filament\Resources\LinkTerkaitResource\Pages;

use App\Filament\Resources\LinkTerkaitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinkTerkait extends EditRecord
{
    protected static string $resource = LinkTerkaitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
