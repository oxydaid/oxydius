<div>
    <div class="container px-6 py-12 mx-auto">
        <div class="max-w-4xl p-6 mx-auto bg-zinc-800 rounded-lg shadow-lg">
            
            <div class="text-center">
                <!-- Ikon Divisi -->
                <img class="object-cover w-32 h-32 mx-auto rounded-lg" 
                     src="{{ $division->icon ? asset('storage/' . $division->icon) : 'https://placehold.co/128x128/22c55e/ffffff?text=' . $division->name }}" 
                     alt="{{ $division->name }} Icon">
                
                <!-- Nama Divisi -->
                <h2 class="mt-4 text-4xl font-bold text-white">{{ $division->name }}</h2>
                
                <!-- DESKRIPSI -->
                <p class="mt-2 text-lg text-zinc-300">
                    {{ $division->description }}
                </p>
            </div>

            <hr class="my-8 border-zinc-700">

            <!-- Bagian Ketua Divisi -->
            <div class="text-center">
                <h3 class="text-2xl font-semibold text-white">Ketua Divisi</h3>
                @if ($head)
                    {{-- 
                      --- PERBAIKAN DI SINI ---
                      1. Ganti 'inline-block' menjadi 'block' dan tambah 'mx-auto'
                      2. Bungkus 'x-init' dengan '$nextTick()'
                    --}}
                    <div class="block w-full max-w-sm p-6 mx-auto mt-4 text-center bg-zinc-900 rounded-lg shadow-lg"
                         x-data="{ 
                             gamertag: '{{ $head->user->gamertag }}',
                             skinUrl: '{{ $head->user->skin ? asset('storage/' . $head->user->skin) : '' }}'
                         }"
                         x-init="$nextTick(() => initSingleSkinViewer($el.querySelector('.skin-renderer'), gamertag, skinUrl))">
                        
                        <a href="{{ route('user-profile', ['gamertag' => $head->user->gamertag]) }}">
                            <canvas class="mx-auto h-64 skin-renderer"></canvas>
                            <h4 class="mt-4 text-2xl font-semibold bg-linear-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">
                                {{ $head->user->gamertag }}
                            </h4>
                            <p class="mt-1 font-medium text-zinc-300">{{ $head->position }}</p>
                        </a>
                    </div>
                @else
                    <p class="mt-4 text-zinc-400">Ketua divisi belum ditetapkan.</p>
                @endif
            </div>

            <hr class="my-8 border-zinc-700">

            <!-- Bagian Anggota Divisi -->
            <div class="text-center">
                <h3 class="text-2xl font-semibold text-white">Anggota Divisi</h3>
                
                <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($members as $member)
                        {{-- 
                          --- PERBAIKAN DI SINI ---
                          1. Bungkus 'x-init' dengan '$nextTick()'
                        --}}
                        <div class="p-6 text-center bg-zinc-900 rounded-lg shadow-lg"
                             x-data="{ 
                                 gamertag: '{{ $member->user->gamertag }}',
                                 skinUrl: '{{ $member->user->skin ? asset('storage/' . $member->user->skin) : '' }}'
                             }"
                             x-init="$nextTick(() => initSingleSkinViewer($el.querySelector('.skin-renderer'), gamertag, skinUrl))">
                            
                            <a href="{{ route('user-profile', ['gamertag' => $member->user->gamertag]) }}">
                                <canvas class="mx-auto h-64 skin-renderer"></canvas>
                                <h4 class="mt-4 text-xl font-semibold bg-linear-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">
                                    {{ $member->user->gamertag }}
                                </h4>
                                <p class="mt-1 font-medium text-zinc-300">{{ $member->position }}</p>
                            </a>
                        </div>
                    @empty
                        <p class="text-zinc-400 md:col-span-3">Belum ada anggota di divisi ini.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>