<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananResource\Pages;
use App\Models\Layanan;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Guava\FilamentIconPicker\Forms\IconPicker;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?string $pluralLabel = 'Daftar Layanan';
    protected static ?int $navigationSort = 7;

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

                Forms\Components\TextInput::make('nama_layanan')
                    ->label('Nama Layanan')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('deskripsi_singkat')
                    ->label('Deskripsi Singkat')
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('deskripsi_full')
                    ->label('Deskripsi Lengkap')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike', 'link', 
                        'bulletList', 'orderedList', 'blockquote',
                        'undo', 'redo',
                    ])
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('thumb')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('layanan/thumbs')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048),

                // Icon Picker
                IconPicker::make('icon')
                    ->label('Ikon')
                    ->sets(['heroicons', 'fontawesome-solid'])
                    ->columns(3)
                    ->helperText('Pilih ikon untuk layanan ini.'),
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
                    ->label('Thumb')
                    ->circular()
                    ->toggleable(),
                
                // IconColumn untuk menampilkan icon di tabel
                \Guava\FilamentIconPicker\Tables\IconColumn::make('icon')
                    ->label('Icon')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('nama_layanan')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug disalin!')
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('deskripsi_singkat')
                    ->label('Deskripsi Singkat')
                    ->limit(50)
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
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }

    // ✅ Filter query: User non-admin hanya melihat layanan OPD-nya
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
