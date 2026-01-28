<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $pluralLabel = 'Daftar Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $navigationGroup = 'Manajemen Sistem';
    protected static ?int $navigationSort = 2;

    // ✅ Hanya tampilkan untuk admin (opds_id = null)
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->opds_id === null;
    }

    // ✅ Hanya admin yang bisa akses (security layer)
    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->opds_id === null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ahmad Fauzi'),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('contoh@email.com')
                            ->prefixIcon('heroicon-o-envelope'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('OPD & Subdomain')
                    ->schema([
                        Forms\Components\Select::make('opds_id')
                            ->label('OPD/Instansi')
                            ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->helperText('Pilih OPD yang akan dikelola user ini'),

                        Forms\Components\TextInput::make('subdomain')
                            ->label('Subdomain')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Contoh: bkpsdm, dinkes, kecamatan-alas (tanpa spasi)')
                            ->placeholder('bkpsdm')
                            ->regex('/^[a-z0-9\-]+$/')
                            ->validationMessages([
                                'regex' => 'Subdomain hanya boleh huruf kecil, angka, dan tanda strip (-)',
                            ])
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Password')
                    ->description('Set password untuk user ini')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->helperText(fn (string $context): string => 
                                $context === 'edit' 
                                    ? 'Kosongkan jika tidak ingin mengubah password' 
                                    : 'Minimal 8 karakter'
                            )
                            ->minLength(8),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->same('password')
                            ->dehydrated(false)
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->visible(fn (Forms\Get $get): bool => filled($get('password')))
                            ->minLength(8),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email disalin!')
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('subdomain')
                    ->label('Subdomain')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Subdomain disalin!')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-link')
                    ->default('-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('opd.nama_opd')
                    ->label('OPD/Instansi')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(40),

                Tables\Columns\TextColumn::make('opd.status')
                    ->label('Jenis OPD')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        1 => 'OPD',
                        2 => 'Kecamatan',
                        default => '-',
                    })
                    ->colors([
                        'primary' => 1,
                        'success' => 2,
                    ])
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Email Terverifikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn ($state) => $state ? 'Terverifikasi' : 'Belum')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('opds_id')
                    ->label('OPD/Instansi')
                    ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('opd_status')
                    ->label('Jenis OPD')
                    ->query(function ($query, array $data) {
                        if (filled($data['value'])) {
                            $query->whereHas('opd', function ($q) use ($data) {
                                $q->where('status', $data['value']);
                            });
                        }
                    })
                    ->options([
                        1 => 'OPD',
                        2 => 'Kecamatan',
                    ]),

                Tables\Filters\TernaryFilter::make('subdomain')
                    ->label('Memiliki Subdomain')
                    ->nullable()
                    ->placeholder('Semua')
                    ->trueLabel('Ya')
                    ->falseLabel('Tidak')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('subdomain'),
                        false: fn (Builder $query) => $query->whereNull('subdomain'),
                    ),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Status Verifikasi Email')
                    ->nullable()
                    ->placeholder('Semua')
                    ->trueLabel('Terverifikasi')
                    ->falseLabel('Belum Terverifikasi')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn (Builder $query) => $query->whereNull('email_verified_at'),
                    ),
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
            ->emptyStateHeading('Belum ada pengguna')
            ->emptyStateDescription('Silakan tambahkan pengguna baru untuk OPD')
            ->emptyStateIcon('heroicon-o-users');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query untuk hanya menampilkan user yang memiliki OPD
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNotNull('opds_id');
    }
}
