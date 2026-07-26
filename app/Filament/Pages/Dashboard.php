<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CustomWelcomeWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\LatestRegistrations;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Ikon navigasi di sidebar
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // Judul halaman
    protected static ?string $title = 'Dashboard';

    // Mengatur jumlah kolom grid (2 kolom agar Stats dan Tabel rapi)
    public function getColumns(): int | string | array
    {
        return 2;
    }

    // Daftar widget yang akan ditampilkan
    public function getWidgets(): array
    {
        return [
            
            // 2. Widget Statistik (4 Kartu)
            StatsOverview::class,       
            
            // 3. Widget Tabel Pendaftaran (Full Width)
            LatestRegistrations::class, 
        ];
    }
}