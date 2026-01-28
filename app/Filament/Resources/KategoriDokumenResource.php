<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriDokumenResource\Pages;
use App\Models\KategoriDokumen;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KategoriDokumenResource extends Resource
{
    protected static ?string $model = KategoriDokumen::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $pluralModelLabel = 'Dokumen';
    protected static ?string $modelLabel = 'Dokumen';
    protected static ?int $navigationSort = 1;
    
    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $form
            ->schema([
                // ✅ Tampilkan select OPD hanya untuk admin
                Forms\Components\Select::make('opds_id')
                    ->label('OPD/Instansi')
                    ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->visible($isAdmin)
                    ->columnSpanFull(),

                // ✅ Tampilkan info OPD untuk user non-admin (read-only)
                Forms\Components\Placeholder::make('opd_info')
                    ->label('OPD/Instansi')
                    ->content(fn () => auth()->user()->opd?->nama_opd ?? '-')
                    ->visible(!$isAdmin)
                    ->columnSpanFull(),

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
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->maxLength(500),

                        Forms\Components\Select::make('type_file')
                            ->label('Tipe Dokumen')
                            ->options([
                                'url' => 'URL/Link',
                                'file' => 'File Upload',
                                'text' => 'Text/Konten',
                            ])
                            ->live()
                            ->required(),

                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->visible(fn ($get) => $get('type_file') === 'url')
                            ->maxLength(255)
                            ->placeholder('https://example.com'),

                        Forms\Components\FileUpload::make('file')
                            ->label('Upload File')
                            ->directory('dokumen')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(10240)
                            ->visible(fn ($get) => $get('type_file') === 'file')
                            ->helperText('Format: PDF, Word, Excel (Max 10MB)'),

                        Forms\Components\RichEditor::make('text')
                            ->label('Isi Konten')
                            ->visible(fn ($get) => $get('type_file') === 'text')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike', 
                                'link', 'bulletList', 'orderedList', 
                                'undo', 'redo',
                            ]),

                        Forms\Components\DatePicker::make('tanggal')
                            ->default(now())
                            ->label('Tanggal')
                            ->required(),

                        Forms\Components\Toggle::make('status')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => $state['judul'] ?? null)
                    ->createItemButtonLabel('+ Tambah Dokumen')
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->reorderable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable(),

                // ✅ Tampilkan kolom OPD hanya untuk admin
                Tables\Columns\TextColumn::make('opd.nama_opd')
                    ->label('OPD/Instansi')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(30)
                    ->visible($isAdmin),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('dokumens_count')
                    ->counts('dokumens')
                    ->label('Jumlah Dokumen')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                // ✅ Filter OPD hanya untuk admin
                Tables\Filters\SelectFilter::make('opds_id')
                    ->label('OPD/Instansi')
                    ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                    ->searchable()
                    ->preload()
                    ->visible($isAdmin),
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

    // ✅ Filter query: User non-admin hanya melihat kategori dokumen OPD-nya
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Jika user bukan admin (punya opds_id), filter berdasarkan OPD-nya
        if (auth()->check() && auth()->user()->opds_id) {
            $query->where('opds_id', auth()->user()->opds_id);
        }

        return $query;
    }
}
