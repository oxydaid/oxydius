<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan model User di-import

class MemberProfile extends Component
{
    #[Title('Oxydius Member - Profile')] 
    /**
     * @var User
     */
    public $user;

    /**
     * Inisialisasi komponen dengan data user yang sedang login.
     * Kita 'eager load' relasi agar tidak terjadi N+1 problem.
     */
    public function mount()
    {
        // Ambil user yang login, lalu load relasinya
        $this->user = Auth::user()->load([
            'clanMember.division', // Load data clanMember DAN data division-nya
            'tags'                 // Load semua tags
        ]);
    }

    public function render()
    {
        return view('livewire.member-profile');
    }
}