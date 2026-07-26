<div>
    {{-- Navbar --}}
    <x-navbar />

    <div class="container px-6 py-12 mx-auto">
        
        {{-- Header & Search --}}
        <div class="flex flex-col items-center justify-between mb-10 md:flex-row">
            <div>
                <h1 class="text-3xl font-bold text-white">Divisi Clan</h1>
                <p class="mt-2 text-zinc-400">Temukan peran yang sesuai dengan gaya bermainmu.</p>
            </div>

            {{-- Input Pencarian --}}
            <div class="relative mt-4 md:mt-0 w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       class="w-full py-2 pl-10 pr-4 text-white placeholder-zinc-500 bg-zinc-800 border border-zinc-700 rounded-lg focus:border-green-500 focus:ring-green-500 focus:outline-none" 
                       placeholder="Cari Divisi...">
            </div>
        </div>

        {{-- Grid Divisi --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($divisions as $division)
                <a href="{{ route('division', $division->slug) }}" 
                   class="group relative flex flex-col h-full p-6 transition-all duration-300 bg-zinc-800 border border-zinc-700 rounded-xl hover:bg-zinc-750 hover:border-green-500/50 hover:shadow-lg hover:shadow-green-900/20 hover:-translate-y-1">
                    
                    <div class="flex items-start justify-between">
                        {{-- Ikon Divisi --}}
                        <img class="object-cover w-16 h-16 rounded-lg  group-hover:scale-105 transition-transform duration-300" 
                             src="{{ $division->icon ? asset('storage/' . $division->icon) : 'https://placehold.co/100x100/22c55e/ffffff?text=' . $division->name }}" 
                             alt="{{ $division->name }} Icon">
                        
                        {{-- Badge Jumlah Anggota --}}
                        <span class="px-2 py-1 text-xs font-medium text-green-400 bg-green-900/30 rounded-full border border-green-900/50">
                            {{ $division->members_count }} Anggota
                        </span>
                    </div>

                    {{-- Info --}}
                    <div class="mt-5 grow">
                        <h3 class="text-xl font-semibold text-white group-hover:text-green-400 transition-colors">
                            {{ $division->name }}
                        </h3>
                        <p class="mt-2 text-sm text-zinc-400 line-clamp-3">
                            {{ $division->description ?? 'Tidak ada deskripsi untuk divisi ini.' }}
                        </p>
                    </div>

                    {{-- Tombol "Lihat Detail" (Visual saja, seluruh kartu bisa diklik) --}}
                    <div class="mt-6">
                         {{-- Menggunakan span agar valid HTML di dalam tag <a>, tapi di-style seperti button --}}
                         <span class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-all duration-300 transform rounded-lg shadow-md bg-linear-to-r from-green-500 to-emerald-600 group-hover:from-green-600 group-hover:to-emerald-700 group-hover:scale-105">
                            Lihat Detail
                            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-zinc-800 border border-zinc-700">
                        <svg class="w-8 h-8 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white">Tidak ada divisi ditemukan</h3>
                    <p class="mt-1 text-zinc-400">Coba cari dengan kata kunci lain.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $divisions->links('components.pagination') }} 
        </div>
    </div>
</div>