<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananResource\Pages;
use App\Models\Layanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Guava\FilamentIconPicker\Forms\IconPicker; // Import IconPicker

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?string $pluralLabel = 'Daftar Layanan';
    protected static ?int $navigationSort = 5; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_layanan')
                    ->label('Nama Layanan')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                Forms\Components\TextInput::make('deskripsi_singkat')
                    ->label('Deskripsi Singkat')
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('deskripsi_full')
                    ->label('Deskripsi Lengkap')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike', 'link', 'bulletList', 'orderedList', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('thumb')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('layanan/thumbs')
                    ->imagePreviewHeight('100'),

                // Ganti Select dengan IconPicker
                IconPicker::make('icon')
                    ->label('Ikon')
                    ->sets(['heroicons', 'fontawesome-solid']) // Pilih icon sets yang ingin digunakan
                    ->columns(3) // Tampilkan 3 kolom
                    ->helperText('Pilih ikon untuk layanan ini.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No')->sortable(),                
                Tables\Columns\ImageColumn::make('thumb')->label('Thumb')->circular(),
                
                // Gunakan IconColumn untuk menampilkan icon di tabel
                \Guava\FilamentIconPicker\Tables\IconColumn::make('icon')
                    ->label('Icon'),
                
                Tables\Columns\TextColumn::make('nama_layanan')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->searchable(),
                Tables\Columns\TextColumn::make('deskripsi_singkat')->label('Deskripsi Singkat')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }
}
