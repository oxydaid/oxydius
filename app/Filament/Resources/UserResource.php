<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Data User')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Data Akun')
                            ->icon('heroicon-o-user-circle')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('password')
                                    ->password()
                                    // Hanya hash jika diisi (saat buat/edit password)
                                    ->dehydrateStateUsing(
                                        fn(?string $state): ?string =>
                                        filled($state) ? Hash::make($state) : null
                                    )
                                    // Jangan kirim password saat load form (edit)
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(string $context): bool => $context === 'create') // Wajib saat create
                                    ->helperText('Kosongkan jika tidak ingin mengubah password.'),
                                Forms\Components\Checkbox::make('is_admin')
                                    ->label('Admin Website?')
                                    ->helperText('Admin bisa mengakses panel ini.'),
                            ]),

                        Tab::make('Profil Clan')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                TextInput::make('gamertag')
                                    ->label('Gamertag Minecraft')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Nomor Telepon/WA')
                                    ->tel()
                                    ->maxLength(255),

                                FileUpload::make('skin')
                                    ->label('Skin')
                                    ->directory('skins')
                                    ->image(), // Tampilkan sbg avatar
                                FileUpload::make('avatar')
                                    ->label('Foto Profil')
                                    ->directory('avatars')
                                    ->image()
                                    ->imageEditor()
                                    ->avatar(), // Tampilkan sbg avatar
                                // Kita akan handle 'skin' di fitur #4
                            ]),

                        Tab::make('Struktur & Tag')
                            ->icon('heroicon-o-rectangle-stack')
                            ->schema([
                                // Ini akan mengedit relasi hasOne (ClanMember)
                                Section::make('Struktur Clan')
                                    ->relationship('clanMember') // Hubungkan ke relasi 'clanMember' di model User
                                    ->schema([
                                        Select::make('division_id')
                                            ->label('Divisi')
                                            ->relationship('division', 'name') // Relasi 'division' di model ClanMember
                                            ->searchable()
                                            ->preload()
                                            ->nullable(),
                                        TextInput::make('position')
                                            ->required()
                                            ->label('Jabatan')
                                            ->helperText('Contoh: Ketua, Wakil, Anggota'),
                                    ])->columns(2),

                                // Ini akan mengedit relasi belongsToMany (Tags)
                                Section::make('Tags')
                                    ->schema([
                                        Select::make('tags') // Nama relasi 'tags' di model User
                                            ->label('Pilih Tag')
                                            ->relationship('tags', 'name') // Relasi 'tags' di model User
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->placeholder('Pilih satu atau lebih tag'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('gamertag')
                    ->label('Gamertag')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default

                // Ambil dari relasi ClanMember
                TextColumn::make('clanMember.position')
                    ->label('Jabatan')
                    ->searchable()
                    ->default('-')
                    ->badge(),

                // Ambil dari relasi ClanMember -> Division
                TextColumn::make('clanMember.division.name')
                    ->label('Divisi')
                    ->searchable()
                    ->badge()
                    ->default('-'),

                // Ambil dari relasi Tags
                TagsColumn::make('tags.name') // Tampilkan semua tag
                    ->label('Tags'),

                IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
