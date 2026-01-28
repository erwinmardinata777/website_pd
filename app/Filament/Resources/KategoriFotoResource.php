<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriFotoResource\Pages;
use App\Models\KategoriFoto;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class KategoriFotoResource extends Resource
{
    protected static ?string $model = KategoriFoto::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Galeri';
    protected static ?string $pluralModelLabel = 'Foto';
    protected static ?string $modelLabel = 'Foto';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $form
            ->schema([
                // ✅ Section untuk OPD (khusus admin)
                Forms\Components\Section::make('Informasi OPD')
                    ->description('Pilih OPD/Instansi untuk kategori foto ini')
                    ->schema([
                        Forms\Components\Select::make('opds_id')
                            ->label('OPD/Instansi')
                            ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->visible($isAdmin)
                    ->collapsible(),

                // ✅ Placeholder untuk user non-admin
                Forms\Components\Section::make('Informasi OPD')
                    ->description('OPD/Instansi Anda')
                    ->schema([
                        Forms\Components\Placeholder::make('opd_info')
                            ->label('OPD/Instansi')
                            ->content(fn () => auth()->user()->opd?->nama_opd ?? '-')
                            ->columnSpanFull(),
                    ])
                    ->visible(!$isAdmin)
                    ->collapsible(),

                // Section untuk Informasi Kategori
                Forms\Components\Section::make('Informasi Kategori')
                    ->description('Masukkan detail kategori foto')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->label('Nama Kategori')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('slug', Str::slug($state))
                            )
                            ->placeholder('Contoh: Kegiatan Sekolah')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->helperText('Generate otomatis dari nama kategori'),

                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Section untuk Galeri Foto
                Forms\Components\Section::make('Galeri Foto')
                    ->description('Upload dan kelola foto dalam kategori ini')
                    ->schema([
                        Forms\Components\Repeater::make('fotos')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('judul')
                                            ->label('Judul Foto')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Contoh: Upacara Bendera')
                                            ->columnSpanFull()
                                            ->live(onBlur: true),

                                        Forms\Components\FileUpload::make('gambar')
                                            ->label('Upload Gambar')
                                            ->image()
                                            ->columnSpanFull()
                                            ->directory('fotos')
                                            ->maxSize(2048)
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])
                                            ->imagePreviewHeight('200')
                                            ->required()
                                            ->helperText('Max 2MB. Format: JPG, PNG, WebP'),
                                    ]),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['judul'] ?? 'Foto Baru')
                            ->collapsible()
                            ->collapsed()
                            ->cloneable()
                            ->reorderableWithButtons()
                            ->addActionLabel('+ Tambah Foto')
                            ->deleteAction(
                                fn ($action) => $action->requiresConfirmation()
                            )
                            ->defaultItems(0)
                            ->minItems(0)
                            ->maxItems(50)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable()
                    ->toggleable(),

                // ✅ Tampilkan kolom OPD hanya untuk admin
                Tables\Columns\TextColumn::make('opd.nama_opd')
                    ->label('OPD/Instansi')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(30)
                    ->visible($isAdmin),
                    
                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap()
                    ->icon('heroicon-o-folder'),
                    
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->limit(25)
                    ->toggleable()
                    ->copyable()
                    ->copyMessage('Slug disalin!')
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('fotos_count')
                    ->label('Jumlah Foto')
                    ->counts('fotos')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-photo')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),
                    
                Tables\Columns\TextColumn::make('hits')
                    ->label('Dilihat')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-eye')
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('tanggal', 'desc')
            ->filters([
                // ✅ Filter OPD hanya untuk admin
                Tables\Filters\SelectFilter::make('opds_id')
                    ->label('OPD/Instansi')
                    ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                    ->searchable()
                    ->preload()
                    ->visible($isAdmin),

                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['sampai'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Belum ada kategori foto')
            ->emptyStateDescription('Silakan buat kategori foto baru dengan klik tombol di bawah')
            ->emptyStateIcon('heroicon-o-photo');
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
            'index' => Pages\ListKategoriFotos::route('/'),
            'create' => Pages\CreateKategoriFoto::route('/create'),
            'edit' => Pages\EditKategoriFoto::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat kategori foto OPD-nya
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
