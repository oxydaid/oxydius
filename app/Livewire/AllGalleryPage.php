<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.app.home', ['description' => 'Lihat koleksi lengkap foto dokumentasi kegiatan clan Oxydius di halaman galeri kami. Temukan momen-momen berharga yang telah kami abadikan.'])]
#[Title('Oxydius - Galeri Foto Clan')]
class AllGalleryPage extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $galleries = Gallery::where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15); // 15 foto per halaman

        return view('livewire.all-gallery-page', [
            'galleries' => $galleries
        ]);
    }
}