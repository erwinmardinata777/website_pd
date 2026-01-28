<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengaduanResource\Pages;
use App\Models\Pengaduan;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Pengaduan';
    protected static ?string $pluralLabel = 'Daftar Pengaduan';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi OPD Tujuan')
                    ->description('OPD yang menangani pengaduan ini')
                    ->schema([
                        Forms\Components\Select::make('opds_id')
                            ->label('OPD/Instansi Tujuan')
                            ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($record) => $record !== null) // Tidak bisa diubah setelah dibuat
                            ->dehydrated()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Data Pelapor')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Pelapor')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('telp')
                            ->label('No. Telepon')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('kecamatan.nama_kecamatan')
                            ->label('Kecamatan')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('desa.nama_desa')
                            ->label('Desa/Kelurahan')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Detail Pengaduan')
                    ->schema([
                        Forms\Components\TextInput::make('pengaduan')
                            ->label('Judul Pengaduan')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('isi_pengaduan')
                            ->label('Isi Pengaduan')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('bukti')
                            ->label('Bukti Foto/Dokumen')
                            ->disabled()
                            ->dehydrated(false)
                            ->image()
                            ->imagePreviewHeight('200')
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('tanggal_pengaduan')
                            ->label('Tanggal Pengaduan')
                            ->disabled()
                            ->dehydrated(false)
                            ->native(false),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Status Penanganan')
                    ->description('Update status penanganan pengaduan')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                0 => 'Baru',
                                1 => 'Sedang Diproses',
                                2 => 'Selesai',
                            ])
                            ->required()
                            ->default(0)
                            ->helperText('Ubah status sesuai dengan progres penanganan pengaduan'),
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
                    ->label('OPD Tujuan')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(25)
                    ->visible($isAdmin),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Pelapor')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('telp')
                    ->label('Telp')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('No. telp disalin!')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('pengaduan')
                    ->label('Judul Pengaduan')
                    ->limit(40)
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('kecamatan.nama_kecamatan')
                    ->label('Kecamatan')
                    ->limit(20)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('desa.nama_desa')
                    ->label('Desa')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => 0,
                        'warning' => 1,
                        'success' => 2,
                    ])
                    ->icons([
                        'heroicon-o-clock' => 0,
                        'heroicon-o-arrow-path' => 1,
                        'heroicon-o-check-circle' => 2,
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        0 => 'Baru',
                        1 => 'Proses',
                        2 => 'Selesai',
                        default => 'Tidak Diketahui',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_pengaduan')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('balasan_count')
                    ->counts('balasan')
                    ->label('Balasan')
                    ->badge()
                    ->color('info')
                    ->toggleable(),
            ])
            ->defaultSort('tanggal_pengaduan', 'desc')
            ->filters([
                // ✅ Filter OPD hanya untuk admin
                Tables\Filters\SelectFilter::make('opds_id')
                    ->label('OPD Tujuan')
                    ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                    ->searchable()
                    ->preload()
                    ->visible($isAdmin),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        0 => 'Baru',
                        1 => 'Sedang Diproses',
                        2 => 'Selesai',
                    ]),

                Tables\Filters\Filter::make('tanggal_pengaduan')
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
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pengaduan', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pengaduan', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->label('Update Status'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('Belum ada pengaduan')
            ->emptyStateDescription('Pengaduan dari masyarakat akan muncul di sini')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right');
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
            'edit' => Pages\EditPengaduan::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat pengaduan OPD-nya
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
