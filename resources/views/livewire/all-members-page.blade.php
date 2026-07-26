<div>
    {{-- Navbar --}}
    <x-navbar />

    <div class="container px-6 py-12 mx-auto">
        
        {{-- Header & Search --}}
        <div class="flex flex-col items-center justify-between mb-10 md:flex-row">
            <div>
                <h1 class="text-3xl font-bold text-white">Daftar Anggota</h1>
                <p class="mt-2 text-zinc-400">Komunitas kami yang terus berkembang.</p>
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
                       placeholder="Cari Gamertag...">
            </div>
        </div>

        {{-- Grid Anggota --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @forelse($members as $member)
                <a href="{{ route('user-profile', ['gamertag' => $member->user->gamertag]) }}" 
                   class="group relative flex flex-col items-center p-6 transition-all duration-300 bg-zinc-800 border border-zinc-700 rounded-xl hover:bg-zinc-750 hover:border-green-500/50 hover:shadow-lg hover:shadow-green-900/20 hover:-translate-y-1">
                    
                    {{-- Avatar (Thumbnail) --}}
                    <div class="relative">
                        <img class="object-cover w-20 h-20 rounded-lg shadow-md group-hover:scale-105 transition-transform duration-300" 
                             src="{{ $member->user->avatar ? asset('storage/' . $member->user->avatar) : 'https://i.pinimg.com/736x/85/78/bf/8578bfd439ef6ee41e103ae82b561986.jpg' }}" 
                             alt="{{ $member->user->gamertag }}">
                        
                        {{-- Badge Divisi (Kecil di pojok) --}}
                        @if($member->division)
                            <div class="absolute -bottom-2 -right-2 bg-zinc-900 rounded-full p-1 border border-zinc-700" title="{{ $member->division->name }}">
                                <img src="{{ $member->division->icon ? asset('storage/' . $member->division->icon) : 'https://placehold.co/32x32/22c55e/ffffff?text=D' }}" 
                                     class="w-6 h-6 rounded-full">
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="mt-4 text-center">
                        <h3 class="text-lg font-semibold text-white group-hover:text-green-400 transition-colors truncate w-full px-2">
                            {{ $member->user->gamertag }}
                        </h3>
                        <p class="text-sm font-medium text-zinc-300 text-primary-500 mt-1">{{ $member->position }}</p>
                        <p class="text-xs text-zinc-500 mt-0.5">{{ $member->division?->name ?? 'Tanpa Divisi' }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-zinc-800">
                        <svg class="w-8 h-8 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white">Tidak ada anggota ditemukan</h3>
                    <p class="mt-1 text-zinc-400">Coba cari dengan kata kunci lain.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination (Jika ada banyak halaman) --}}
        <div class="mt-10">
            {{ $members->links('components.pagination') }} 
            {{-- Pastikan Anda sudah publish pagination views Laravel agar stylenya cocok, 
                 atau biarkan default Tailwind --}}
        </div>
    </div>
</div>