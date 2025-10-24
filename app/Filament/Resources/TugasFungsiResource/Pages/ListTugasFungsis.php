<?php

namespace App\Filament\Resources\TugasFungsiResource\Pages;

use App\Filament\Resources\TugasFungsiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugasFungsis extends ListRecords
{
    protected static string $resource = TugasFungsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
