<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkTerkaitResource\Pages;
use App\Models\LinkTerkait;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LinkTerkaitResource extends Resource
{
    protected static ?string $model = LinkTerkait::class;
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $pluralModelLabel = 'Link Terkait';
    protected static ?string $modelLabel = 'Link Terkait';
    protected static ?int $navigationSort = 5;

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
                    ->label('Judul')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Portal Resmi Kabupaten Sumbawa'),

                Forms\Components\TextInput::make('link')
                    ->label('URL / Tautan')
                    ->placeholder('https://example.com')
                    ->url()
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-link')
                    ->helperText('Masukkan alamat tautan tujuan, misalnya https://sumbawakab.go.id'),

                Forms\Components\FileUpload::make('thumb')
                    ->label('Gambar/Logo')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->columnSpanFull()
                    ->directory('link-terkait')
                    ->maxSize(2048)
                    ->helperText('Upload gambar/logo untuk link terkait (Max 2MB).'),
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

                Tables\Columns\ImageColumn::make('thumb')
                    ->label('Gambar/Logo')
                    ->height(50)
                    ->square(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('link')
                    ->label('URL')
                    ->limit(40)
                    ->url(fn ($record) => $record->link, true)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->copyable()
                    ->copyMessage('URL disalin!')
                    ->toggleable(),

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
            ->emptyStateHeading('Belum ada link terkait')
            ->emptyStateDescription('Silakan tambahkan link terkait dengan klik tombol di bawah')
            ->emptyStateIcon('heroicon-o-link');
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
            'index' => Pages\ListLinkTerkaits::route('/'),
            'create' => Pages\CreateLinkTerkait::route('/create'),
            'edit' => Pages\EditLinkTerkait::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat link terkait OPD-nya
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
