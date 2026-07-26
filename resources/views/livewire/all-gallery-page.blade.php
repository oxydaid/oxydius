<div>
    {{-- Navbar --}}
    <x-navbar />

    <div class="container px-6 py-12 mx-auto" x-data="{ open: false, currentImage: '', currentTitle: '' }">
        
        {{-- Header & Search --}}
        <div class="flex flex-col items-center justify-between mb-10 md:flex-row">
            <div>
                <h1 class="text-3xl font-bold text-white">Galeri Dokumentasi</h1>
                <p class="mt-2 text-zinc-400">Jelajahi momen-momen terbaik clan kami.</p>
            </div>

            {{-- Input Pencarian --}}
            <div class="relative mt-4 w-full md:w-64 md:mt-0">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       class="w-full py-2 pl-10 pr-4 text-white placeholder-zinc-500 bg-zinc-800 border border-zinc-700 rounded-lg focus:border-green-500 focus:ring-green-500 focus:outline-none" 
                       placeholder="Cari Judul Foto...">
            </div>
        </div>

        {{-- Grid Foto --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            @forelse($galleries as $photo)
                <div @click="open = true; currentImage = '{{ asset('storage/' . $photo->image_path) }}'; currentTitle = '{{ $photo->title ?? $photo->description }}'"
                     class="relative w-full overflow-hidden transition-transform duration-300 transform bg-zinc-800 rounded-lg shadow-lg cursor-pointer aspect-square group hover:scale-[1.03] hover:shadow-2xl hover:shadow-green-900/20">
                    
                    <img src="{{ asset('storage/' . $photo->image_path) }}" 
                         alt="{{ $photo->title }}" 
                         class="object-cover w-full h-full transition duration-500 group-hover:opacity-80">
                    
                    {{-- Hover Caption --}}
                    @if($photo->title)
                        <div class="absolute inset-0 flex items-end justify-center p-3 text-center text-white transition duration-300 opacity-0 bg-black/40 group-hover:opacity-100">
                            <p class="text-sm font-medium line-clamp-2">{{ $photo->title }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-zinc-400">
                    <p>Belum ada foto yang tersedia di Galeri.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $galleries->links('components.pagination') }} 
        </div>

        {{-- Lightbox / Modal (Alpine.js) --}}
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.outside="open = false"
             @keydown.escape.window="open = false"
             class="fixed inset-0 z-100 flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm"
             style="display: none;"
        >
            <div @click.stop 
                 class="relative max-w-full max-h-full overflow-hidden bg-zinc-900 rounded-lg shadow-2xl shadow-black/50"
            >
                <button @click="open = false" 
                        class="absolute top-2 right-2 z-10 p-2 text-white transition-colors bg-black/50 rounded-full hover:bg-black/80 focus:outline-none">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <img :src="currentImage" :alt="currentTitle" class="object-contain w-auto max-w-full max-h-[90vh]">
                
                <div x-show="currentTitle" class="absolute bottom-0 left-0 right-0 p-3 text-center text-white bg-black/60">
                    <span x-text="currentTitle"></span>
                </div>
            </div>
        </div>
    </div>
</div>