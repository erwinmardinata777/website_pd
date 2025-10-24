<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkTerkaitResource\Pages;
use App\Filament\Resources\LinkTerkaitResource\RelationManagers;
use App\Models\LinkTerkait;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LinkTerkaitResource extends Resource
{
    protected static ?string $model = LinkTerkait::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $pluralModelLabel = 'Link Terkait';
    protected static ?string $modelLabel = 'Link Terkait';
    protected static ?int $navigationSort = 5; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->label('Judul')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('link')
                    ->label('URL / Tautan')
                    ->placeholder('https://example.com')
                    ->url()
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255)
                    ->helperText('Masukkan alamat tautan tujuan, misalnya https://sumbawakab.go.id'),

                Forms\Components\FileUpload::make('thumb')
                    ->label('Gambar/Logo')
                    ->image()
                    ->imagePreviewHeight('100')
                    ->columnSpanFull()
                    ->directory('link-terkait')
                    ->maxSize(2048)
                    ->helperText('Upload gambar/logo untuk link terkait.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No'),
                Tables\Columns\ImageColumn::make('thumb')
                    ->label('Gambar')
                    ->height(40),
                Tables\Columns\TextColumn::make('judul')->searchable(),
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
            'index' => Pages\ListLinkTerkaits::route('/'),
            'create' => Pages\CreateLinkTerkait::route('/create'),
            'edit' => Pages\EditLinkTerkait::route('/{record}/edit'),
        ];
    }
}
