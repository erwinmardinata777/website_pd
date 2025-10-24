<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TugasFungsiResource\Pages;
use App\Filament\Resources\TugasFungsiResource\RelationManagers;
use App\Models\TugasFungsi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TugasFungsiResource extends Resource
{
    protected static ?string $model = TugasFungsi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Tugas & Fungsi';
    protected static ?string $pluralLabel = 'Tugas dan Fungsi';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?int $navigationSort = 3; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('thumb')
                    ->label('Gambar (opsional)')
                    ->image()
                    ->directory('tugas-fungsi')
                    ->maxSize(2048)
                    ->columnSpanFull()
                    ->imagePreviewHeight('120'),

                Forms\Components\RichEditor::make('isi')
                    ->label('Isi')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->label('Judul')->searchable(),
                Tables\Columns\ImageColumn::make('thumb')->label('Gambar'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),                
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTugasFungsis::route('/'),
            'create' => Pages\CreateTugasFungsi::route('/create'),
            'edit' => Pages\EditTugasFungsi::route('/{record}/edit'),
        ];
    }

    // ✅ Hanya tampilkan tombol "Tambah" jika belum ada data
    public static function canCreate(): bool
    {
        return TugasFungsi::count() === 0;
    }    

}
