<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OpdResource\Pages;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OpdResource extends Resource
{
    protected static ?string $model = Opd::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'OPD';
    protected static ?string $pluralLabel = 'Daftar OPD';
    protected static ?string $modelLabel = 'OPD';
    protected static ?string $navigationGroup = 'Manajemen Sistem';
    protected static ?int $navigationSort = 1;

    // ✅ Hanya tampilkan untuk admin (opds_id = null)
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->opds_id === null;
    }

    // ✅ Hanya admin yang bisa akses (security layer)
    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->opds_id === null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_opd')
                    ->label('Nama OPD')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->placeholder('Contoh: Dinas Kesehatan')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug (Auto Generate)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->columnSpanFull()
                    ->dehydrated()
                    ->maxLength(255)
                    ->helperText('Slug akan di-generate otomatis dari nama OPD'),

                Forms\Components\Select::make('status')
                    ->label('Jenis')
                    ->options([
                        1 => 'OPD',
                        2 => 'Kecamatan',
                    ])
                    ->default(1)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('nama_opd')
                    ->label('Nama OPD')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug disalin!')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        1 => 'OPD',
                        2 => 'Kecamatan',
                        default => 'Tidak Diketahui',
                    })
                    ->colors([
                        'primary' => 1,
                        'success' => 2,
                    ])
                    ->sortable(),

                // ✅ Counter relasi
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('User')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-users')
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
                Tables\Filters\SelectFilter::make('status')
                    ->label('Jenis')
                    ->options([
                        1 => 'OPD',
                        2 => 'Kecamatan',
                    ]),
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
            ->emptyStateHeading('Belum ada OPD')
            ->emptyStateDescription('Silakan tambahkan OPD/Instansi baru')
            ->emptyStateIcon('heroicon-o-building-office-2');
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
            'index' => Pages\ListOpds::route('/'),
            'create' => Pages\CreateOpd::route('/create'),
            'edit' => Pages\EditOpd::route('/{record}/edit'),
        ];
    }
}
