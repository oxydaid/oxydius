<?php

namespace App\Livewire;

use App\Models\AppSetting;
use App\Models\ClanMember;
use App\Models\Division;
use App\Models\Gallery;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

// Menggunakan layout 'guest' yang baru kita buat
#[Layout('components.layouts.app.home')] 
// Mengatur Judul Halaman
#[Title('Oxydius - Selamat Datang di Oxydius')] 
class Home extends Component
{
    public $divisions;
    public $leaders;
    public $galleries;
    public $settings;

    /**
     * Ambil data saat komponen di-load.
     */
    public function mount()
    {
        // Ambil 4 divisi (sesuai mockup)
        $this->divisions = Division::take(4)->get();

        // Ambil 4 petinggi clan (misal Ketua, Wakil, dll)
        // Kita juga load 'user' dan 'division' agar datanya siap
        $this->leaders = ClanMember::whereIn('position', ['Ketua', 'Wakil', 'Ketua Divisi'])
                                    ->with('user', 'division')
                                    ->take(4)
                                    ->get();

        $this->galleries = Gallery::where('is_active', true)
                                  ->latest()
                                  ->take(10) 
                                  ->get();
        $this->settings = AppSetting::first();
    }

    public function render()
    {
        return view('livewire.home');
    }
}