<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriDokumenResource\Pages;
use App\Filament\Resources\KategoriDokumenResource\RelationManagers;
use App\Models\KategoriDokumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriDokumenResource extends Resource
{
    protected static ?string $model = KategoriDokumen::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $pluralModelLabel = 'Dokumen';
    protected static ?string $modelLabel = 'Dokumen';
    protected static ?int $navigationSort = 1; // urutan pertama
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul Kategori Dokumen')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->live(onBlur: true),

                // 🔹 Repeater untuk menambah dokumen langsung di bawah kategori
                Forms\Components\Repeater::make('dokumens')
                    ->label('Daftar Dokumen')
                    ->relationship('dokumens')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Dokumen')
                            ->required(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(2),

                        Forms\Components\Select::make('type_file')
                            ->label('Tipe Dokumen')
                            ->options([
                                'url' => 'URL',
                                'file' => 'File',
                                'text' => 'Text',
                            ])
                            ->reactive()
                            ->required(),

                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->visible(fn ($get) => $get('type_file') === 'url')
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('file')
                            ->label('File')
                            ->directory('dokumen')
                            ->visible(fn ($get) => $get('type_file') === 'file'),

                        Forms\Components\RichEditor::make('text')
                            ->label('Isi Text')
                            ->visible(fn ($get) => $get('type_file') === 'text'),

                        Forms\Components\DatePicker::make('tanggal')
                            ->default(now())
                            ->label('Tanggal'),

                        Forms\Components\Toggle::make('status')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->collapsible()
                    ->createItemButtonLabel('Tambah Dokumen')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No'),
                Tables\Columns\TextColumn::make('judul')->searchable(),
                Tables\Columns\TextColumn::make('dokumens_count')
                    ->counts('dokumens')
                    ->label('Jumlah Dokumen'),
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
            'index' => Pages\ListKategoriDokumens::route('/'),
            'create' => Pages\CreateKategoriDokumen::route('/create'),
            'edit' => Pages\EditKategoriDokumen::route('/{record}/edit'),
        ];
    }
}
