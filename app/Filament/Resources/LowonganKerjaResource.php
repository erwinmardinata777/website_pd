<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LowonganKerjaResource\Pages;
use App\Filament\Resources\LowonganKerjaResource\RelationManagers;
use App\Models\LowonganKerja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LowonganKerjaResource extends Resource
{
    protected static ?string $model = LowonganKerja::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $pluralModelLabel = 'Lowongan Kerja';
    protected static ?string $modelLabel = 'Lowongan Kerja';
    protected static ?int $navigationSort = 1; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('judul')
                ->label('Judul Lowongan')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('nama_perusahaan')
                ->label('Nama Perusahaan')
                ->required(),

            Forms\Components\RichEditor::make('deskripsi')
                ->label('Deskripsi')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('alamat')
                ->label('Alamat'),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal')
                ->default(now()),

            // 🔹 Repeater untuk Foto Lowongan
            Forms\Components\Repeater::make('fotoLowongans')
                ->label('Foto Lowongan')
                ->relationship('fotoLowongans')
                ->schema([
                    Forms\Components\FileUpload::make('foto')
                        ->label('Upload Foto')
                        ->image()
                        ->directory('lowongan_foto')
                        ->maxSize(2048)
                        ->required(),
                ])
                ->collapsible()
                ->createItemButtonLabel('Tambah Foto')
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No')->sortable(),                
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('nama_perusahaan')->label('Perusahaan'),
                Tables\Columns\TextColumn::make('tanggal')->label('Tanggal')->date('d M Y'),
                Tables\Columns\TextColumn::make('fotoLowongans_count')
                    ->counts('fotoLowongans')
                    ->label('Jumlah Foto'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLowonganKerjas::route('/'),
            'create' => Pages\CreateLowonganKerja::route('/create'),
            'edit' => Pages\EditLowonganKerja::route('/{record}/edit'),
        ];
    }
}
