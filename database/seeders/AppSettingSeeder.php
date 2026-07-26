<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppSetting::firstOrCreate(
            ['id' => 1],
            [
                'app_name' => 'Nama Clan Anda',
                'theme' => '#f59e0b', // Warna oranye/amber sebagai default
            ]
        );
    }
}
