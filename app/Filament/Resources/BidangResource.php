<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BidangResource\Pages;
use App\Models\Bidang;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BidangResource extends Resource
{
    protected static ?string $model = Bidang::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Bidang';
    protected static ?string $pluralModelLabel = 'Bidang';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?int $navigationSort = 6;

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

                Forms\Components\TextInput::make('nama_bidang')
                    ->label('Nama Bidang')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('thumb')
                    ->label('Thumbnail')
                    ->columnSpanFull()
                    ->directory('thumbs/bidang')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->maxSize(2048),

                Forms\Components\RichEditor::make('deskripsi')
                    ->label('Deskripsi')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'bulletList',
                        'orderedList',
                        'link',
                        'blockquote',
                        'codeBlock',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull()
                    ->nullable(),                    
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
                    ->label('Thumbnail')
                    ->square()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('nama_bidang')
                    ->label('Nama Bidang')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('pegawais_count')
                    ->label('Jumlah Pegawai')
                    ->counts('pegawais')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Dibuat')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y')
                    ->label('Diperbarui')
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListBidangs::route('/'),
            'create' => Pages\CreateBidang::route('/create'),
            'edit' => Pages\EditBidang::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat bidang OPD-nya
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
