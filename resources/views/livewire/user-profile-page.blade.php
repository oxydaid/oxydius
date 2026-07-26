<div>
<h1 class="text-2xl font-bold text-center pt-8 pb-0 bg-linear-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">Profil Member Oxydius</h1>
    <div class="container px-6 py-12 mx-auto">
        {{-- 2. Tampilkan Profil --}}
        <div class="max-w-4xl p-6 mx-auto bg-zinc-800 rounded-lg shadow-lg">
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                {{-- KOLOM KIRI: Skin Renderer & Gamertag --}}
                <div class="flex flex-col items-center md:col-span-1"
                     x-data="{ 
                         gamertag: '{{ $user->gamertag }}',
                         skinUrl: '{{ $user->skin ? asset('storage/' . $user->skin) : '' }}'
                     }"
                     x-init="initSingleSkinViewer($el.querySelector('.skin-renderer'), gamertag, skinUrl)"
                >
                    {{-- Canvas untuk 3D Skin Renderer --}}
                    <canvas class="mx-auto h-64 skin-renderer"></canvas>

                    <h2 class="flex items-center mt-4 text-3xl font-bold text-white">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://crafatar.com/avatars/' . $user->gamertag . '?size=32&overlay' }}"
                            class="inline-block w-8 h-8 mr-3 rounded-sm" alt="Avatar" />
                        {{ $user->gamertag }}
                    </h2>
                </div>

                {{-- KOLOM KANAN: Detail Info --}}
                <div class="md:col-span-2">
                    <h3 class="text-2xl font-semibold text-white">
                        {{ $user->name }}
                    </h3>

                    <p class="mt-1 text-lg text-zinc-400">
                        {{ $user->email }}
                    </p>

                    <hr class="my-4 border-zinc-700">

                    {{-- Info Divisi & Jabatan --}}
                    <div>
                        <h4 class="text-sm font-semibold text-zinc-400 uppercase">Jabatan</h4>
                        <p class="text-xl text-white">
                            {{ $user->clanMember?->position ?? 'Belum Diatur' }}
                        </p>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-sm font-semibold text-zinc-400 uppercase">Divisi</h4>
                        <div class="flex items-center mt-1">
                            @if ($user->clanMember?->division)
                                @if ($user->clanMember->division->icon)
                                    <img src="{{ asset('storage/' . $user->clanMember->division->icon) }}"
                                        class="w-8 h-8 mr-3 rounded-md" alt="Ikon Divisi">
                                @endif
                                <span class="text-xl text-white">
                                    {{ $user->clanMember->division->name }}
                                </span>
                            @else
                                <span class="text-xl text-white">Belum ada divisi</span>
                            @endif
                        </div>
                    </div>

                    {{-- Info Tags --}}
                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-zinc-400 uppercase">Tags</h4>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @forelse($user->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-white rounded-full"
                                    style="background-color: {{ $tag->color ?? '#6B7280' }};">
                                    @if ($tag->icon)
                                        <img src="{{ asset('storage/' . $tag->icon) }}" class="w-4 h-4 mr-1.5"
                                            alt="Ikon Tag">
                                    @endif
                                    {{ $tag->name }}
                                </span>
                            @empty
                                <span class="text-sm text-zinc-400">Tidak ada tag.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>