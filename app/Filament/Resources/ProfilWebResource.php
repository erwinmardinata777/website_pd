<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilWebResource\Pages;
use App\Models\ProfilWeb;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProfilWebResource extends Resource
{
    protected static ?string $model = ProfilWeb::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Profil Website';
    protected static ?string $modelLabel = 'Profil Web';
    protected static ?string $pluralLabel = 'Profil Web';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $form
            ->schema([
                // ✅ Section OPD (khusus admin)
                Forms\Components\Section::make('Informasi OPD')
                    ->description('Pilih OPD untuk profil website ini')
                    ->schema([
                        Forms\Components\Select::make('opds_id')
                            ->label('OPD/Instansi')
                            ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Setiap OPD memiliki 1 profil website'),
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

                Forms\Components\Section::make('Informasi Dasar Website')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Website')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Dinas Kesehatan Kabupaten Sumbawa')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Deskripsi singkat untuk meta description')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('deskripsi_full')
                            ->label('Deskripsi Lengkap Tentang OPD')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'link', 'bulletList', 'orderedList',
                                'h2', 'h3', 'blockquote', 'codeBlock',
                                'undo', 'redo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('keyword')
                            ->label('Kata Kunci SEO')
                            ->maxLength(255)
                            ->placeholder('kata kunci, dipisah, dengan, koma')
                            ->helperText('Kata kunci untuk SEO, pisahkan dengan koma')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('url')
                            ->label('URL Website')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://dinkes.sumbawakab.go.id')
                            ->prefixIcon('heroicon-o-link'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Forms\Components\Section::make('Kontak & Alamat')
                    ->schema([
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat Kantor')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-envelope'),

                        Forms\Components\TextInput::make('telp')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(50)
                            ->prefixIcon('heroicon-o-phone'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('facebook')
                            ->label('Facebook')
                            // ->url()
                            ->maxLength(255)
                            ->placeholder('https://facebook.com/username')
                            ->prefixIcon('heroicon-o-link'),

                        Forms\Components\TextInput::make('twitter')
                            ->label('Twitter/X')
                            // ->url()
                            ->maxLength(255)
                            ->placeholder('https://twitter.com/username')
                            ->prefixIcon('heroicon-o-link'),

                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            // ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/username')
                            ->prefixIcon('heroicon-o-link'),

                        Forms\Components\TextInput::make('youtube')
                            ->label('YouTube')
                            // ->url()
                            ->maxLength(255)
                            ->placeholder('https://youtube.com/@username')
                            ->prefixIcon('heroicon-o-link'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Peta & Media')
                    ->schema([
                        Forms\Components\Textarea::make('googlemap')
                            ->label('Embed Google Maps')
                            ->rows(4)
                            ->placeholder('<iframe src="..." width="600" height="450" ...></iframe>')
                            ->helperText('Paste kode embed dari Google Maps')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('bg')
                            ->label('Background Header')
                            ->directory('profilweb/bg')
                            ->image()
                            ->imagePreviewHeight('150')
                            ->maxSize(2048)
                            ->helperText('Background untuk header website (Max 2MB)'),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo OPD')
                            ->directory('profilweb/logo')
                            ->image()
                            ->imagePreviewHeight('150')
                            ->maxSize(2048)
                            ->helperText('Logo resmi OPD (Max 2MB)'),
                    ])
                    ->columns(2)
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

                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->square()
                    ->height(50),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Website')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap()
                    ->limit(40),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->copyMessage('Email disalin!')
                    ->icon('heroicon-o-envelope')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('telp')
                    ->label('Telepon')
                    ->copyable()
                    ->copyMessage('No. telp disalin!')
                    ->icon('heroicon-o-phone')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->limit(30)
                    ->url(fn ($record) => $record->url, true)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('primary')
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
                    ->toggleable(),
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
            ->emptyStateHeading('Belum ada profil website')
            ->emptyStateDescription('Silakan buat profil website untuk OPD Anda')
            ->emptyStateIcon('heroicon-o-globe-alt');
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
            'index' => Pages\ListProfilWebs::route('/'),
            'create' => Pages\CreateProfilWeb::route('/create'),
            'edit' => Pages\EditProfilWeb::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat profil web OPD-nya
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Jika user bukan admin (punya opds_id), filter berdasarkan OPD-nya
        if (auth()->check() && auth()->user()->opds_id) {
            $query->where('opds_id', auth()->user()->opds_id);
        }

        return $query;
    }

    // ✅ Hanya tampilkan tombol "Tambah" jika OPD belum punya profil web
    public static function canCreate(): bool
    {
        // Admin selalu bisa create
        if (auth()->user()->opds_id === null) {
            return true;
        }

        // User OPD: cek apakah sudah punya profil web
        $hasProfilWeb = ProfilWeb::where('opds_id', auth()->user()->opds_id)->exists();
        
        // Jika sudah punya profil web, tidak bisa create lagi (hanya edit)
        return !$hasProfilWeb;
    }
}
