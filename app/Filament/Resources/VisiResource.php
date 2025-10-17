<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisiResource\Pages;
use App\Filament\Resources\VisiResource\RelationManagers;
use App\Models\Visi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisiResource extends Resource
{
    protected static ?string $model = Visi::class;
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?string $pluralModelLabel = 'Visi';
    protected static ?string $modelLabel = 'Visi';
    protected static ?int $navigationSort = 4; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('visi')
                    ->label('Teks Visi')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link', 'redo', 'undo'
                    ])
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('visi')
                    ->limit(100)
                    ->label('Isi Visi')
                    ->html(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListVisis::route('/'),
            'create' => Pages\CreateVisi::route('/create'),
            'edit' => Pages\EditVisi::route('/{record}/edit'),
        ];
    }

    // ✅ Hanya tampilkan tombol "Tambah" jika belum ada data
    public static function canCreate(): bool
    {
        return Visi::count() === 0;
    }    

}
