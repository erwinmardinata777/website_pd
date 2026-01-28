<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?string $pluralModelLabel = 'Pegawai';
    protected static ?string $modelLabel = 'Pegawai';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->opds_id === null;
        $currentOpdId = auth()->user()->opds_id;

        return $form
            ->schema([
                // ✅ Section OPD (khusus admin)
                Forms\Components\Section::make('Informasi OPD')
                    ->description('Pilih OPD/Instansi untuk pegawai ini')
                    ->schema([
                        Forms\Components\Select::make('opds_id')
                            ->label('OPD/Instansi')
                            ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Reset bidang ketika OPD berubah
                                $set('bidangs_id', null);
                                $set('parent', null);
                            }),
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

                Forms\Components\Section::make('Data Pribadi')->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('nip')
                        ->label('NIP')
                        ->maxLength(30),

                    Forms\Components\TextInput::make('tempat_lahir')
                        ->label('Tempat Lahir')
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->native(false)
                        ->displayFormat('d/m/Y'),

                    Forms\Components\Select::make('agama')
                        ->options([
                            'Islam' => 'Islam',
                            'Kristen' => 'Kristen',
                            'Katolik' => 'Katolik',
                            'Hindu' => 'Hindu',
                            'Buddha' => 'Buddha',
                            'Konghucu' => 'Konghucu',
                        ]),

                    Forms\Components\Select::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ]),

                    Forms\Components\Textarea::make('alamat')
                        ->label('Alamat Lengkap')
                        ->rows(3)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('no_hp')
                        ->label('No. HP')
                        ->tel()
                        ->maxLength(20),

                    Forms\Components\Select::make('status_kawin')
                        ->label('Status Perkawinan')
                        ->options([
                            'Belum Kawin' => 'Belum Kawin',
                            'Kawin' => 'Kawin',
                            'Cerai Hidup' => 'Cerai Hidup',
                            'Cerai Mati' => 'Cerai Mati',
                        ]),
                ])->columns(2)->collapsible(),

                Forms\Components\Section::make('Data Jabatan')->schema([
                    Forms\Components\Select::make('bidangs_id')
                        ->label('Bidang')
                        ->options(function () use ($isAdmin, $currentOpdId) {
                            // Admin: tampilkan semua bidang
                            // User OPD: hanya bidang dari OPD-nya
                            if ($isAdmin) {
                                return Bidang::query()
                                    ->orderBy('nama_bidang')
                                    ->pluck('nama_bidang', 'id');
                            } else {
                                return Bidang::query()
                                    ->where('opds_id', $currentOpdId)
                                    ->orderBy('nama_bidang')
                                    ->pluck('nama_bidang', 'id');
                            }
                        })
                        ->searchable()
                        ->preload(),

                    Forms\Components\TextInput::make('jabatan')
                        ->label('Jabatan')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('pangkat_golongan')
                        ->label('Pangkat/Golongan')
                        ->maxLength(255),

                    Forms\Components\Select::make('parent')
                        ->label('Atasan Langsung')
                        ->options(function () use ($isAdmin, $currentOpdId) {
                            // Admin: tampilkan semua pegawai
                            // User OPD: hanya pegawai dari OPD-nya
                            if ($isAdmin) {
                                return Pegawai::query()
                                    ->orderBy('nama')
                                    ->pluck('nama', 'id');
                            } else {
                                return Pegawai::query()
                                    ->where('opds_id', $currentOpdId)
                                    ->orderBy('nama')
                                    ->pluck('nama', 'id');
                            }
                        })
                        ->searchable()
                        ->placeholder('Tidak ada (Kepala Dinas/Bidang)')
                        ->preload(),
                ])->columns(2)->collapsible(),

                Forms\Components\Section::make('Pendidikan & Media Sosial')->schema([
                    Forms\Components\TextInput::make('pendidikan_terakhir')
                        ->label('Pendidikan Terakhir')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('facebook')
                        ->label('Facebook')
                        ->url()
                        ->maxLength(255)
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\TextInput::make('instagram')
                        ->label('Instagram')
                        ->url()
                        ->maxLength(255)
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\TextInput::make('twitter')
                        ->label('Twitter/X')
                        ->url()
                        ->maxLength(255)
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\TextInput::make('youtube')
                        ->label('YouTube')
                        ->url()
                        ->maxLength(255)
                        ->prefixIcon('heroicon-o-link'),
                ])->columns(2)->collapsible(),

                Forms\Components\FileUpload::make('foto')
                    ->label('Foto Pegawai')
                    ->image()
                    ->directory('pegawai')
                    ->imagePreviewHeight('200')
                    ->columnSpanFull()
                    ->maxSize(2048)
                    ->helperText('Max 2MB. Format: JPG, PNG, WebP'),
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
                    ->limit(25)
                    ->visible($isAdmin),

                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('NIP disalin!')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->limit(25)
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('bidang.nama_bidang')
                    ->label('Bidang')
                    ->wrap()
                    ->limit(30)
                    ->sortable(),

                Tables\Columns\TextColumn::make('atasan.nama')
                    ->label('Atasan')
                    ->default('-')
                    ->limit(25)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('pangkat_golongan')
                    ->label('Pangkat/Gol')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nama', 'asc')
            ->filters([
                // ✅ Filter OPD hanya untuk admin
                Tables\Filters\SelectFilter::make('opds_id')
                    ->label('OPD/Instansi')
                    ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                    ->searchable()
                    ->preload()
                    ->visible($isAdmin),

                Tables\Filters\SelectFilter::make('bidangs_id')
                    ->label('Bidang')
                    ->options(function () use ($isAdmin) {
                        if ($isAdmin) {
                            return Bidang::query()->orderBy('nama_bidang')->pluck('nama_bidang', 'id');
                        } else {
                            return Bidang::query()
                                ->where('opds_id', auth()->user()->opds_id)
                                ->orderBy('nama_bidang')
                                ->pluck('nama_bidang', 'id');
                        }
                    })
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
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
            ->emptyStateHeading('Belum ada data pegawai')
            ->emptyStateDescription('Silakan tambahkan data pegawai dengan klik tombol di bawah')
            ->emptyStateIcon('heroicon-o-user-group');
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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat pegawai OPD-nya
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
