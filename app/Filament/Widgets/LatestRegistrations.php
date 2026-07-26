<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\RegistrationResource;
use App\Models\Registration;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRegistrations extends BaseWidget
{
    protected static ?int $sort = 3; // Di bawah stats
    
    protected int | string | array $columnSpan = 'full'; // Memenuhi lebar layar

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Hanya ambil yang statusnya 'pending'
                Registration::query()->where('status', 'pending')
            )
            ->heading('Pendaftaran Menunggu Review')
            ->description('Daftar calon anggota baru yang perlu persetujuan.')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Daftar')
                    ->dateTime()
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('gamertag')
                    ->label('Gamertag')
                    ->copyable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Divisi Pilihan')
                    ->badge()
                    ->color('info'),
            ])
            ->actions([
                // Tombol aksi untuk langsung membuka detail pendaftaran di Resource
                Tables\Actions\Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-m-eye')
                    ->button()
                    ->url(fn (Registration $record): string => RegistrationResource::getUrl('index')), // Arahkan ke index resource (karena kita matikan halaman view/edit terpisah)
            ])
            ->emptyStateHeading('Tidak ada pendaftaran baru')
            ->emptyStateDescription('Semua pendaftaran telah diproses.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}