<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app.home')] // Menggunakan layout yang sama dengan Home
class UserProfilePage extends Component
{
    public User $user;

    // Judul halaman akan di-set secara dinamis
    #[Title('Oxydius - Profil Anggota')] 
    public function mount(string $gamertag)
    {
        // Cari user berdasarkan 'gamertag'
        // Muat relasi yang kita perlukan (clanMember, division, tags)
        // Jika tidak ditemukan, otomatis tampilkan halaman 404
        $this->user = User::where('gamertag', $gamertag)
                        ->with(['clanMember.division', 'tags'])
                        ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.user-profile-page');
    }
}