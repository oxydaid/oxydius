<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\ClanMember; // <-- IMPORT
use App\Models\Registration;
use App\Models\User; // <-- IMPORT
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section; // <-- IMPORT
use Filament\Forms\Components\Grid; // <-- IMPORT
use Filament\Forms\Components\Checkbox; // <-- IMPORT
use Filament\Tables\Actions\Action; // <-- IMPORT
use Filament\Tables\Filters\SelectFilter; // <-- IMPORT
use Illuminate\Database\Eloquent\Builder; // <-- IMPORT
use Illuminate\Support\Facades\Hash; // <-- IMPORT
use Filament\Notifications\Notification; // <-- IMPORT

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Pendaftaran';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Data Pendaftar')
                        ->columnSpan(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->disabled(),
                            Forms\Components\TextInput::make('email')
                                ->disabled(),
                            Forms\Components\TextInput::make('gamertag')
                                ->disabled(),
                            Forms\Components\TextInput::make('phone')
                                ->label('Telepon/WA')
                                ->disabled(),
                            Forms\Components\Select::make('division_id')
                                ->label('Divisi Pilihan')
                                ->relationship('division', 'name')
                                ->disabled(),
                        ])->columns(2),
                    
                    Section::make('Status')
                        ->columnSpan(1)
                        ->schema([
                            Forms\Components\Select::make('status') // <-- GANTI JADI SELECT
                                ->options([
                                    'pending' => 'Pending',
                                    'approved' => 'Approved',
                                    'rejected' => 'Rejected',
                                ])
                                ->disabled(),
                            Forms\Components\DateTimePicker::make('created_at')
                                ->label('Waktu Daftar')
                                ->disabled(),
                        ]),
                ]),

                Section::make('Jawaban Pendaftaran (Application Data)')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Textarea::make('application_data.reason')
                            ->label('Alasan Bergabung')
                            ->disabled(),
                        Checkbox::make('application_data.agree_rules')
                            ->label('Setuju menaati aturan clan')
                            ->disabled(),
                        Checkbox::make('application_data.agree_cooperate')
                            ->label('Setuju bekerjasama')
                            ->disabled(),
                        Forms\Components\Textarea::make('application_data.contribution')
                            ->label('Kontribusi ketika diterima')
                            ->disabled(),
                        Forms\Components\Textarea::make('application_data.other_skills')
                            ->label('Kemampuan lain (Opsional)')
                            ->disabled(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // Default: Tampilkan pendaftaran yang masih pending
            ->defaultSort('created_at', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gamertag')
                    ->searchable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Divisi Pilihan')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Daftar')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])->default('pending'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Aksi untuk melihat detail (form read-only)

                // --- AKSI SETUJUI ---
                Action::make('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation() // Minta konfirmasi
                    ->action(function (Registration $record) {
                        // 1. Buat User baru
                        $user = User::create([
                            'name' => $record->name,
                            'email' => $record->email,
                            'gamertag' => $record->gamertag,
                            'phone' => $record->phone,
                            'password' => $record->password, // Password sudah di-hash di model Registration
                            'email_verified_at' => now(), // Anggap sudah terverifikasi
                        ]);

                        // 2. Buat data ClanMember
                        ClanMember::create([
                            'user_id' => $user->id,
                            'division_id' => $record->division_id,
                            'position' => 'Anggota', // Default Jabatan
                        ]);

                        // 3. Update status pendaftaran
                        $record->update(['status' => 'approved']);
                        
                        Notification::make()
                            ->title('Pendaftaran disetujui!')
                            ->body("User {$record->name} ({$record->gamertag}) telah berhasil dibuat.")
                            ->success()
                            ->send();
                    })
                    // Hanya tampilkan tombol jika status masih pending
                    ->visible(fn (Registration $record): bool => $record->status === 'pending'),

                // --- AKSI TOLAK ---
                Action::make('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Registration $record) {
                        $record->update(['status' => 'rejected']);
                        
                        Notification::make()
                            ->title('Pendaftaran ditolak')
                            ->body("Pendaftaran {$record->name} ({$record->gamertag}) telah ditolak.")
                            ->warning()
                            ->send();
                    })
                    // Hanya tampilkan tombol jika status masih pending
                    ->visible(fn (Registration $record): bool => $record->status === 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    // --- PENTING: Matikan halaman "Create" ---
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        // Selalu load relasi division agar tidak N+1
        return parent::getEloquentQuery()->with('division');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            // Kita tidak perlu halaman create dan edit, 
            // jadi kita hapus dari array ini
            // 'create' => Pages\CreateRegistration::route('/create'),
            // 'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Registration::where('status', 'pending')->count();
        return $count > 0 ? (string)$count : null;
    }
}