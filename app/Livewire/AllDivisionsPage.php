<?php

namespace App\Livewire;

use App\Models\Division;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.app.home', ['description' => 'Jelajahi berbagai divisi di Oxydius dan temukan komunitas yang sesuai dengan minat Anda. Bergabunglah dengan kami dan kembangkan potensi Anda bersama kami!'])]
#[Title('Oxydius - Divisi')]
class AllDivisionsPage extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $divisions = Division::withCount('members') // Hitung jumlah anggota
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(12); // 12 divisi per halaman

        return view('livewire.all-divisions-page', [
            'divisions' => $divisions
        ]);
    }
}