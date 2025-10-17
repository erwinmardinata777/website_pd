<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriFotoResource\Pages;
use App\Filament\Resources\KategoriFotoResource\RelationManagers;
use App\Models\KategoriFoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class KategoriFotoResource extends Resource
{
    protected static ?string $model = KategoriFoto::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Galeri';
    protected static ?string $pluralModelLabel = 'Foto';
    protected static ?string $modelLabel = 'Foto';
    protected static ?int $navigationSort = 1; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section untuk Informasi Kategori
                Forms\Components\Section::make('Informasi Kategori')
                    ->description('Masukkan detail kategori foto')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->label('Nama Kategori')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('slug', Str::slug($state))
                            )
                            ->placeholder('Contoh: Kegiatan Sekolah'),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->helperText('Generate otomatis dari nama kategori'),

                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Section untuk Galeri Foto
                Forms\Components\Section::make('Galeri Foto')
                    ->description('Upload dan kelola foto dalam kategori ini')
                    ->schema([
                        Forms\Components\Repeater::make('fotos')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('judul')
                                            ->label('Judul Foto')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Contoh: Upacara Bendera')
                                            ->columnSpanFull()
                                            ->live(onBlur: true),

                                        Forms\Components\FileUpload::make('gambar')
                                            ->label('Upload Gambar')
                                            ->image()
                                            ->columnSpanFull()
                                            ->directory('fotos')
                                            ->maxSize(2048)
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])
                                            ->required()
                                            ->helperText('Max 2MB. Format: JPG, PNG, WebP'),
                                    ]),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['judul'] ?? 'Foto Baru')
                            ->collapsible()
                            ->collapsed()
                            ->cloneable()
                            ->reorderableWithButtons()
                            ->addActionLabel('Tambah Foto')
                            ->deleteAction(
                                fn ($action) => $action->requiresConfirmation()
                            )
                            ->defaultItems(0)
                            ->minItems(0)
                            ->maxItems(50)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-folder'),
                    
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->limit(25)
                    ->toggleable()
                    ->copyable()
                    ->copyMessage('Slug disalin!')
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('fotos_count')
                    ->label('Jumlah Foto')
                    ->counts('fotos')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-photo'),
                    
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),
                    
                Tables\Columns\TextColumn::make('hits')
                    ->label('Dilihat')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-eye'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('tanggal', 'desc')
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari'),
                        Forms\Components\DatePicker::make('sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['sampai'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    }),
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
            ->emptyStateHeading('Belum ada kategori foto')
            ->emptyStateDescription('Silakan buat kategori foto baru dengan klik tombol di bawah')
            ->emptyStateIcon('heroicon-o-photo');
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
            'index' => Pages\ListKategoriFotos::route('/'),
            'create' => Pages\CreateKategoriFoto::route('/create'),
            'edit' => Pages\EditKategoriFoto::route('/{record}/edit'),
        ];
    }
}
