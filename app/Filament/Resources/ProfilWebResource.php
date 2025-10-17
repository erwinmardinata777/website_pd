<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilWebResource\Pages;
use App\Filament\Resources\ProfilWebResource\RelationManagers;
use App\Models\ProfilWeb;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfilWebResource extends Resource
{
    protected static ?string $model = ProfilWeb::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Profil Website';
    protected static ?string $modelLabel = 'Profil Web';
    protected static ?string $pluralLabel = 'Profil Web';
    protected static ?string $navigationGroup = 'Pengaturan Web';
    protected static ?int $navigationSort = 1; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Website')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull()
                    ->rows(3),
                Forms\Components\RichEditor::make('deskripsi_full')
                    ->label('Deskripsi Lengkap')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'link', 'orderedList', 'unorderedList',
                        'blockquote', 'codeBlock'
                    ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('keyword')
                    ->label('Kata Kunci SEO')
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\TextInput::make('url')
                    ->label('URL Website')
                    ->maxLength(255),

                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('telp')
                    ->label('Telepon')
                    ->maxLength(50),

                Forms\Components\TextInput::make('facebook')
                    ->maxLength(255),
                Forms\Components\TextInput::make('twitter')
                    ->maxLength(255),
                Forms\Components\TextInput::make('instagram')
                    ->maxLength(255),
                Forms\Components\TextInput::make('youtube')
                    ->maxLength(255),

                Forms\Components\Textarea::make('googlemap')
                    ->label('Embed Google Maps')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('bg')
                    ->label('Background')
                    ->directory('profilweb/bg')
                    ->image()
                    ->imagePreviewHeight('150px')
                    ->maxSize(2048),

                Forms\Components\FileUpload::make('logo')
                    ->label('Logo')
                    ->directory('profilweb/logo')
                    ->image()
                    ->imagePreviewHeight('150px')
                    ->maxSize(2048),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->square(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('telp')
                    ->label('Telepon'),
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
            'index' => Pages\ListProfilWebs::route('/'),
            'create' => Pages\CreateProfilWeb::route('/create'),
            'edit' => Pages\EditProfilWeb::route('/{record}/edit'),
        ];
    }

    // ✅ Hanya tampilkan tombol "Tambah" jika belum ada data
    public static function canCreate(): bool
    {
        return ProfilWeb::count() === 0;
    }    
}
