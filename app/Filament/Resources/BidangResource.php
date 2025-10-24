<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BidangResource\Pages;
use App\Filament\Resources\BidangResource\RelationManagers;
use App\Models\Bidang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BidangResource extends Resource
{
    protected static ?string $model = Bidang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Bidang';
    protected static ?string $pluralModelLabel = 'Bidang';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?int $navigationSort = 6; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('nama_bidang')->label('Nama Bidang')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->label('Dibuat'),
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
            'index' => Pages\ListBidangs::route('/'),
            'create' => Pages\CreateBidang::route('/create'),
            'edit' => Pages\EditBidang::route('/{record}/edit'),
        ];
    }
}
