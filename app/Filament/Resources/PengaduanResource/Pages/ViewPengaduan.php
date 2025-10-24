<?php

namespace App\Filament\Resources\PengaduanResource\Pages;

use App\Filament\Resources\PengaduanResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\BalasPengaduan;
use Illuminate\Support\Facades\DB;
use Filament\Forms;
use Filament\Notifications\Notification;

class ViewPengaduan extends ViewRecord
{
    protected static string $resource = PengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Forms\Components\Textarea::make('tanggapan')
                ->label('Balasan Pengaduan')
                ->rows(3),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \Filament\Widgets\FormWidget::make()
                ->schema([
                    Forms\Components\Textarea::make('tanggapan')
                        ->label('Tulis Balasan')
                        ->rows(4)
                        ->required(),
                ])
                ->submitAction(function ($data, $record) {
                    DB::transaction(function () use ($data, $record) {
                        BalasPengaduan::create([
                            'pengaduans_id' => $record->id,
                            'tanggapan' => $data['tanggapan'],
                            'tanggal_balas' => now()->toDateString(),
                        ]);

                        $record->update(['status' => 2]);
                    });

                    Notification::make()
                        ->title('Balasan terkirim!')
                        ->success()
                        ->send();
                }),
        ];
    }
}
