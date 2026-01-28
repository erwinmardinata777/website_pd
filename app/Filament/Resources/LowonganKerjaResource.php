<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LowonganKerjaResource\Pages;
use App\Models\LowonganKerja;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LowonganKerjaResource extends Resource
{
    protected static ?string $model = LowonganKerja::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $pluralModelLabel = 'Lowongan Kerja';
    protected static ?string $modelLabel = 'Lowongan Kerja';
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
                    ->label('Judul Lowongan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Lowongan Staff IT')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('nama_perusahaan')
                    ->label('Nama Perusahaan/Instansi')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: PT. Maju Bersama'),

                Forms\Components\TextInput::make('alamat')
                    ->label('Alamat')
                    ->maxLength(255)
                    ->placeholder('Contoh: Jl. Raya Sumbawa No. 123'),

                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal Posting')
                    ->default(now())
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),

                Forms\Components\RichEditor::make('deskripsi')
                    ->label('Deskripsi Lengkap')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'bulletList', 'orderedList',
                        'h2', 'h3', 'blockquote',
                        'undo', 'redo',
                    ]),

                // 🔹 Repeater untuk Foto Lowongan (PERBAIKAN)
                Forms\Components\Section::make('Galeri Foto Lowongan')
                    ->description('Upload foto-foto terkait lowongan kerja')
                    ->schema([
                        Forms\Components\Repeater::make('fotoLowongans')
                            ->label('')
                            ->relationship('fotoLowongans')
                            ->schema([
                                Forms\Components\FileUpload::make('foto')
                                    ->label('Upload Foto')
                                    ->image()
                                    ->directory('lowongan_foto')
                                    ->imagePreviewHeight('200')
                                    ->maxSize(2048)
                                    ->required()
                                    ->helperText('Max 2MB. Format: JPG, PNG, WebP'),
                            ])
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel('Foto Lowongan') // ✅ PERBAIKAN: Label statis
                            ->createItemButtonLabel('+ Tambah Foto')
                            ->reorderableWithButtons()
                            ->deleteAction(
                                fn ($action) => $action->requiresConfirmation()
                            )
                            ->defaultItems(0)
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
                    ->label('Judul Lowongan')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium')
                    ->limit(40),

                Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->label('Perusahaan/Instansi')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(30),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),

                Tables\Columns\TextColumn::make('fotoLowongans_count')
                    ->counts('fotoLowongans')
                    ->label('Jumlah Foto')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-photo')
                    ->sortable(),

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
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
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
            ->emptyStateHeading('Belum ada lowongan kerja')
            ->emptyStateDescription('Silakan tambahkan lowongan kerja dengan klik tombol di bawah')
            ->emptyStateIcon('heroicon-o-briefcase');
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

    // ✅ Filter query: User non-admin hanya melihat lowongan kerja OPD-nya
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
