<?php

namespace App\Livewire;

use App\Models\Division;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app.home')] // Pakai layout 'guest' (dark mode)
class DivisionPage extends Component
{
    public Division $division;
    
    // Kita pisahkan datanya
    public $head = null; // Untuk Ketua Divisi
    public $members = []; // Untuk anggota biasa

    #[Title('Oxydius - Detail Divisi')] 
    public function mount(string $slug)
    {
        // 1. Cari divisi berdasarkan slug, atau 404
        $division = Division::where('slug', $slug)->firstOrFail();

        // 2. Ambil SEMUA anggota divisi ini, beserta data user mereka
        $allMembers = $division->members()->with('user')->get();

        // 3. Pisahkan datanya
        // Cari anggota yang jabatannya 'Ketua Divisi'
        $this->head = $allMembers->firstWhere('position', 'Ketua Divisi');
        if (! $this->head) {
            $this->head = $allMembers->firstWhere('position', 'Ketua');
        }
        
        // Ambil sisanya (yang BUKAN 'Ketua Divisi')
        $this->members = $allMembers->whereNotIn('position', ['Ketua Divisi', 'Ketua']);

        // 4. Set data divisi utama
        $this->division = $division;

        // Set judul halaman secara dinamis
        $this->dispatch('updateTitle', $this->division->name);
    }

    public function render()
    {
        return view('livewire.division-page');
    }
}