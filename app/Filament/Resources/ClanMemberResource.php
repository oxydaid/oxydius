<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClanMemberResource\Pages;
use App\Filament\Resources\ClanMemberResource\RelationManagers;
use App\Models\ClanMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClanMemberResource extends Resource
{
    protected static ?string $model = ClanMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Clan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User (Gamertag)')
                    ->relationship('user', 'gamertag') // Ambil 'gamertag' dari relasi 'user'
                    ->required()
                    ->searchable() // Biar bisa dicari
                    ->preload()      // Langsung load data
                    ->unique(ignoreRecord: true) // Pastikan 1 user hanya 1 data clan (relasi 1-to-1)
                    ->columnSpanFull(),
                Forms\Components\Select::make('division_id')
                    ->label('Divisi')
                    ->relationship('division', 'name') // Ambil 'name' dari relasi 'division'
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\TextInput::make('position')
                    ->label('Jabatan')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Contoh: Ketua, Wakil, Ketua Divisi, Anggota'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.gamertag')
                    ->label('Gamertag')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Divisi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),
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
            'index' => Pages\ListClanMembers::route('/'),
            'create' => Pages\CreateClanMember::route('/create'),
            'edit' => Pages\EditClanMember::route('/{record}/edit'),
        ];
    }
}
