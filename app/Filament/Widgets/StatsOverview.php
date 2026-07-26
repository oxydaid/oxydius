<?php

namespace App\Filament\Widgets;

use App\Models\ClanMember;
use App\Models\Division;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Urutan widget (setelah Welcome widget yang sort=1)
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Ambil member terbaru
        $newestMember = User::latest()->first();

        return [
            Stat::make('Total Divisi', Division::count())
                ->description('Divisi aktif saat ini')
                ->descriptionIcon('heroicon-m-briefcase')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Data dummy chart mini
                ->color('success'),

            Stat::make('Total Anggota', ClanMember::count())
                ->description('Anggota resmi clan')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Petinggi Clan', ClanMember::whereIn('position', ['Ketua', 'Wakil', 'Ketua Divisi'])->count())
                ->description('Struktural inti')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Member Terbaru', $newestMember?->gamertag ?? '-')
                ->description($newestMember ? 'Bergabung ' . $newestMember->created_at->diffForHumans() : 'Belum ada member')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('info'),
        ];
    }
}