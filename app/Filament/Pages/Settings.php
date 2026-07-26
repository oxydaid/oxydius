<?php

namespace App\Filament\Pages;

use App\Models\AppSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle; // <-- IMPORT
use Filament\Forms\Components\Section; // <-- IMPORT
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Aplikasi';
    protected static string $view = 'filament.pages.settings';
    protected static ?int $navigationSort = 100;

    public ?array $data = [];
    public ?AppSetting $settings;

    public function mount(): void
    {
        $this->settings = AppSetting::find(1);
        $this->form->fill($this->settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Bagian 1: Identitas & Tema
                Section::make('Identitas dan Tampilan')
                    ->description('Pengaturan logo, nama, dan warna tema utama.')
                    ->schema([
                        TextInput::make('app_name')
                            ->label('Nama Aplikasi / Clan')
                            ->required(),
                        
                        ColorPicker::make('theme')
                            ->label('Warna Tema Utama')
                            ->hex(),
                            
                        FileUpload::make('logo')
                            ->label('Logo (File .png, .svg)')
                            ->disk('public')
                            ->image()
                            ->imageEditor(),

                        FileUpload::make('favicon')
                            ->label('Favicon (File .ico, .png)')
                            ->disk('public')
                            ->image(),
                    ])->columns(2),

                // Bagian 2: Pengaturan Website
                Section::make('Pengaturan Website')
                    ->description('Pengaturan fungsionalitas dan latar belakang halaman depan.')
                    ->schema([
                        // --- TAMBAHAN BARU ---
                        FileUpload::make('hero_background')
                            ->label('Gambar Background Hero Section')
                            ->disk('public')
                            ->directory('settings')
                            ->image()
                            ->columnSpanFull(),
                        
                        Toggle::make('is_open_member')
                            ->label('Buka Pendaftaran Anggota (Open Member)')
                            ->helperText('Matikan untuk menutup formulir pendaftaran publik.')
                            ->default(true),
                        // --- AKHIR TAMBAHAN BARU ---
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $formData = $this->form->getState();
        $this->settings->update($formData);

        // Hapus cache agar tema dan setting baru diterapkan segera
        Cache::forget('app_settings');

        Notification::make()
            ->title('Pengaturan berhasil disimpan!')
            ->success()
            ->send();
            
        $this->redirect(static::getUrl());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }
}