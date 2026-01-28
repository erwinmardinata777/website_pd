<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisiResource\Pages;
use App\Models\Visi;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VisiResource extends Resource
{
    protected static ?string $model = Visi::class;
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?string $pluralModelLabel = 'Visi';
    protected static ?string $modelLabel = 'Visi';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        $isAdmin = auth()->user()->opds_id === null;

        return $form
            ->schema([
                // ✅ Section OPD (khusus admin)
                Forms\Components\Section::make('Informasi OPD')
                    ->description('Pilih OPD untuk visi ini')
                    ->schema([
                        Forms\Components\Select::make('opds_id')
                            ->label('OPD/Instansi')
                            ->options(Opd::query()->orderBy('nama_opd')->pluck('nama_opd', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Setiap OPD memiliki 1 visi organisasi'),
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

                Forms\Components\RichEditor::make('visi')
                    ->label('Teks Visi')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'bulletList', 'orderedList', 'link',
                        'blockquote', 'h2', 'h3',
                        'redo', 'undo'
                    ])
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Masukkan visi organisasi OPD Anda'),
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

                Tables\Columns\TextColumn::make('visi')
                    ->label('Isi Visi')
                    ->limit(100)
                    ->html()
                    ->wrap()
                    ->searchable(),

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
            ->defaultSort('updated_at', 'desc')
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
            ->emptyStateHeading('Belum ada visi')
            ->emptyStateDescription('Silakan tambahkan visi organisasi untuk OPD Anda')
            ->emptyStateIcon('heroicon-o-eye');
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
            'index' => Pages\ListVisis::route('/'),
            'create' => Pages\CreateVisi::route('/create'),
            'edit' => Pages\EditVisi::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat visi OPD-nya
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Jika user bukan admin (punya opds_id), filter berdasarkan OPD-nya
        if (auth()->check() && auth()->user()->opds_id) {
            $query->where('opds_id', auth()->user()->opds_id);
        }

        return $query;
    }

    // ✅ Hanya tampilkan tombol "Tambah" jika OPD belum punya visi
    public static function canCreate(): bool
    {
        // Admin selalu bisa create
        if (auth()->user()->opds_id === null) {
            return true;
        }

        // User OPD: cek apakah sudah punya visi
        $hasVisi = Visi::where('opds_id', auth()->user()->opds_id)->exists();
        
        // Jika sudah punya visi, tidak bisa create lagi (hanya edit)
        return !$hasVisi;
    }
}
