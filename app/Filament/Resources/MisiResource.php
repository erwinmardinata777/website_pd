<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MisiResource\Pages;
use App\Models\Misi;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MisiResource extends Resource
{
    protected static ?string $model = Misi::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?string $pluralModelLabel = 'Misi';
    protected static ?string $modelLabel = 'Misi';
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
                    ->label('Judul Misi')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Contoh: Meningkatkan Kualitas Pelayanan Publik'),

                Forms\Components\RichEditor::make('deskripsi')
                    ->label('Deskripsi Misi')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'bulletList', 'orderedList', 'link',
                        'blockquote', 'h2', 'h3',
                        'redo', 'undo'
                    ])
                    ->columnSpanFull(),
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
                    ->label('Judul Misi')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium')
                    ->limit(50),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(80)
                    ->html()
                    ->wrap()
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
            ->defaultSort('id', 'asc')
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
            ->emptyStateHeading('Belum ada misi')
            ->emptyStateDescription('Silakan tambahkan misi dengan klik tombol di bawah')
            ->emptyStateIcon('heroicon-o-flag');
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
            'index' => Pages\ListMisis::route('/'),
            'create' => Pages\CreateMisi::route('/create'),
            'edit' => Pages\EditMisi::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat misi OPD-nya
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
