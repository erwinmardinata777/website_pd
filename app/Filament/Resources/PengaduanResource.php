<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaduanResource\Pages;
use App\Filament\Resources\PengaduanResource\RelationManagers;
use App\Models\Pengaduan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Pengaduan';
    protected static ?string $pluralLabel = 'Daftar Pengaduan';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?int $navigationSort = 1; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('nama')->label('Nama'),
                Tables\Columns\TextColumn::make('telp')->label('Telp'),
                Tables\Columns\TextColumn::make('pengaduan')->label('Judul Pengaduan')->limit(30),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 0,
                        'warning' => 1,
                        'success' => 2,
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        0 => 'Baru',
                        1 => 'Proses',
                        2 => 'Selesai',
                    }),
                Tables\Columns\TextColumn::make('tanggal_pengaduan')
                    ->label('Tanggal Pengaduan')
                    ->date(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // hanya view
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengaduans::route('/'),
            'view' => Pages\ViewPengaduan::route('/{record}'),            
        ];
    }
}
