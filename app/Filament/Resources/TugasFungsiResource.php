<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TugasFungsiResource\Pages;
use App\Models\TugasFungsi;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TugasFungsiResource extends Resource
{
    protected static ?string $model = TugasFungsi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Tugas & Fungsi';
    protected static ?string $pluralLabel = 'Tugas dan Fungsi';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $form
            ->schema([
                // ✅ Section OPD (khusus admin)
                Forms\Components\Section::make('Informasi OPD')
                    ->description('Pilih OPD untuk tugas & fungsi ini')
                    ->schema([
                        Forms\Components\Select::make('opds_id')
                            ->label('OPD/Instansi')
                            ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Setiap OPD memiliki 1 dokumen tugas & fungsi'),
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

                Forms\Components\TextInput::make('judul')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Tugas Pokok dan Fungsi')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('thumb')
                    ->label('Gambar Ilustrasi (Opsional)')
                    ->image()
                    ->directory('tugas-fungsi')
                    ->imagePreviewHeight('200')
                    ->maxSize(2048)
                    ->columnSpanFull()
                    ->helperText('Gambar ilustrasi untuk tugas & fungsi (Max 2MB)'),

                Forms\Components\RichEditor::make('isi')
                    ->label('Isi Tugas & Fungsi')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'bulletList', 'orderedList', 'link',
                        'h2', 'h3', 'blockquote', 'codeBlock',
                        'undo', 'redo',
                    ]),
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

                // Tables\Columns\ImageColumn::make('thumb')
                //     ->label('Gambar')
                //     ->square()
                //     ->height(50)
                //     ->defaultImageUrl('/images/placeholder.png'),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
            ->emptyStateHeading('Belum ada dokumen tugas & fungsi')
            ->emptyStateDescription('Silakan tambahkan dokumen tugas & fungsi untuk OPD Anda')
            ->emptyStateIcon('heroicon-o-clipboard-document-check');
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
            'index' => Pages\ListTugasFungsis::route('/'),
            'create' => Pages\CreateTugasFungsi::route('/create'),
            'edit' => Pages\EditTugasFungsi::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat tugas fungsi OPD-nya
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Jika user bukan admin (punya opds_id), filter berdasarkan OPD-nya
        if (auth()->check() && auth()->user()->opds_id) {
            $query->where('opds_id', auth()->user()->opds_id);
        }

        return $query;
    }

    // ✅ Hanya tampilkan tombol "Tambah" jika OPD belum punya tugas fungsi
    public static function canCreate(): bool
    {
        // Admin selalu bisa create
        if (auth()->user()->opds_id === null) {
            return true;
        }

        // User OPD: cek apakah sudah punya tugas fungsi
        $hasTugasFungsi = TugasFungsi::where('opds_id', auth()->user()->opds_id)->exists();
        
        // Jika sudah punya tugas fungsi, tidak bisa create lagi (hanya edit)
        return !$hasTugasFungsi;
    }
}
