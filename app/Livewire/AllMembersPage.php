<?php

namespace App\Livewire;

use App\Models\ClanMember;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.app.home', ['description' => 'Jelajahi daftar lengkap anggota Oxydius. Temukan profil mereka, kontribusi, dan peran mereka dalam komunitas kami yang berkembang pesat!'])]
#[Title('Oxydius - Anggota')]
class AllMembersPage extends Component
{
    use WithPagination;

    // Untuk pencarian (opsional, tapi sangat berguna)
    public $search = '';

    public function render()
    {
        $members = ClanMember::with(['user', 'division'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('gamertag', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })
            // Urutkan custom (Ketua & Wakil di atas)
            // Catatan: Ini logic simpel, bisa disesuaikan
            ->orderByRaw("CASE 
                WHEN position LIKE '%Ketua%' THEN 1 
                WHEN position LIKE '%Wakil%' THEN 2 
                ELSE 3 
            END")
            ->orderBy('created_at', 'asc')
            ->paginate(20); // Tampilkan 20 orang per halaman

        return view('livewire.all-members-page', [
            'members' => $members
        ]);
    }
}