<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use App\Models\Bidang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Profil';
    protected static ?string $pluralModelLabel = 'Pegawai';
    protected static ?string $modelLabel = 'Pegawai';
    protected static ?int $navigationSort = 4; // urutan pertama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')->schema([
                    Forms\Components\TextInput::make('nama')->required(),
                    Forms\Components\TextInput::make('nip')->label('NIP')->maxLength(30),
                    Forms\Components\TextInput::make('tempat_lahir'),
                    Forms\Components\DatePicker::make('tanggal_lahir'),
                    Forms\Components\Select::make('agama')
                        ->options([
                            'Islam' => 'Islam',
                            'Kristen' => 'Kristen',
                            'Katolik' => 'Katolik',
                            'Hindu' => 'Hindu',
                            'Buddha' => 'Buddha',
                            'Konghucu' => 'Konghucu',
                        ]),
                    Forms\Components\Select::make('jenis_kelamin')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ]),
                    Forms\Components\Textarea::make('alamat')->columnSpanFull(),
                    Forms\Components\TextInput::make('no_hp')->label('No. HP'),
                    Forms\Components\Select::make('status_kawin')
                        ->options([
                            'Belum Kawin' => 'Belum Kawin',
                            'Kawin' => 'Kawin',
                            'Cerai Hidup' => 'Cerai Hidup',
                            'Cerai Mati' => 'Cerai Mati',
                        ]),
                ])->columns(2),

                Forms\Components\Section::make('Data Jabatan')->schema([
                    Forms\Components\Select::make('bidangs_id')
                        ->label('Bidang')
                        ->options(Bidang::pluck('nama_bidang', 'id'))
                        ->searchable(),

                    Forms\Components\TextInput::make('jabatan'),
                    Forms\Components\TextInput::make('pangkat_golongan'),
                    Forms\Components\Select::make('parent')
                        ->label('Atasan Langsung')
                        ->options(Pegawai::pluck('nama', 'id'))
                        ->searchable()
                        ->placeholder('Tidak ada (Kepala Bidang)')
                        ->preload(),
                ])->columns(2),

                Forms\Components\Section::make('Pendidikan & Media Sosial')->schema([
                    Forms\Components\TextInput::make('pendidikan_terakhir'),
                    Forms\Components\TextInput::make('facebook'),
                    Forms\Components\TextInput::make('instagram'),
                    Forms\Components\TextInput::make('twitter'),
                    Forms\Components\TextInput::make('youtube'),
                ])->columns(2),

                Forms\Components\FileUpload::make('foto')
                    ->label('Foto Pegawai')
                    ->image()
                    ->directory('pegawai')
                    ->columnSpanFull()
                    ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No'),
                Tables\Columns\ImageColumn::make('foto')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP')->sortable(),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan')->limit(25),
                Tables\Columns\TextColumn::make('bidang.nama_bidang')->label('Bidang'),
                Tables\Columns\TextColumn::make('atasan.nama')->label('Atasan')->default('-'),
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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
