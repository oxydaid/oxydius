<div class="p-6 bg-white rounded-lg shadow-lg dark:bg-zinc-900 border dark:border-zinc-700 ">

    {{-- Grid container, 1 kolom di HP, 3 kolom di desktop --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        {{-- KOLOM KIRI: Skin Renderer & Gamertag --}}
        <div class="flex flex-col items-center md:col-span-1">

            {{-- Canvas untuk 3D Skin Renderer (ID dari Anda) --}}
            <canvas id="skin_container" class="w-full max-w-xs cursor-grab active:cursor-grabbing" style="height: 400px;"></canvas>

            <h2 class="flex items-center mt-4 text-3xl font-bold text-zinc-900 dark:text-white">
                {{-- Avatar (Dinamis: Cek 'avatar' dulu, baru 'gamertag') --}}
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://crafatar.com/avatars/' . $user->gamertag . '?size=32&overlay' }}"
                    class="inline-block w-8 h-8 mr-3 rounded-sm" alt="Avatar" />
                {{ $user->gamertag }}
            </h2>
        </div>

        {{-- KOLOM KANAN: Detail Info --}}
        <div class="md:col-span-2">
            <h3 class="text-2xl font-semibold text-zinc-800 dark:text-zinc-200">
                {{ $user->gamertag }}
            </h3>

            <p class="mt-1 text-lg text-zinc-600 dark:text-zinc-400">
                {{ $user->email }}
            </p>

            <hr class="my-4 border-zinc-200 dark:border-zinc-700">

            {{-- Info Divisi & Jabatan --}}
            <div>
                <h4 class="text-sm font-semibold text-zinc-500 uppercase dark:text-zinc-400">Jabatan</h4>
                <p class="text-xl text-zinc-900 dark:text-white">
                    {{-- Kita gunakan nullsafe operator (?->) untuk keamanan --}}
                    {{ $user->clanMember?->position ?? 'Belum Diatur' }}
                </p>
            </div>

            <div class="mt-4">
                <h4 class="text-sm font-semibold text-zinc-500 uppercase dark:text-zinc-400">Divisi</h4>
                <div class="flex items-center mt-1">
                    @if ($user->clanMember?->division)
                        {{-- Load ikon divisi dari storage --}}
                        @if ($user->clanMember->division->icon)
                            <img src="{{ asset('storage/' . $user->clanMember->division->icon) }}"
                                class="w-8 h-8 mr-3 rounded-md" alt="Ikon Divisi">
                        @endif
                        <span class="text-xl text-zinc-900 dark:text-white">
                            {{ $user->clanMember->division->name }}
                        </span>
                    @else
                        <span class="text-xl text-zinc-900 dark:text-white">Belum ada divisi</span>
                    @endif
                </div>
            </div>

            {{-- Info Tags --}}
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-zinc-500 uppercase dark:text-zinc-400">Tags</h4>
                <div class="flex flex-wrap gap-2 mt-2">
                    @forelse($user->tags as $tag)
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-black rounded-full"
                            style="background-color: {{ $tag->color ?? '#E5E7EB' }};">
                            {{-- Load ikon tag dari storage --}}
                            @if ($tag->icon)
                                <img src="{{ asset('storage/' . $tag->icon) }}" class="w-4 h-4 mr-1.5"
                                    alt="Ikon Tag">
                            @endif
                            {{ $tag->name }}
                        </span>
                    @empty
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">Tidak ada tag.</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT UNTUK 3D SKIN RENDERER --}}

    {{-- 1. Load library skinview3d dari CDN --}}

    <script>
        // Pastikan script ini jalan setelah Livewire selesai render
        document.addEventListener('livewire:navigated', () => {
            initSkinViewer();
        });

        // Panggil juga saat pertama kali load
        initSkinViewer();

        function initSkinViewer() {
            // Cek jika canvas ada dan skin viewer belum diinisialisasi
            let canvas = document.getElementById('skin_container'); // ID dari Anda
            if (canvas && !canvas.skinViewer) {

                let skinViewer = new skinview3d.SkinViewer({
                    canvas: canvas,
                    width: canvas.clientWidth, // Buat responsive
                    height: canvas.clientHeight, // Buat responsive
                });

                // --- Opsi dari script Anda ---
                skinViewer.fov = 70; // Change camera FOV
                skinViewer.zoom = 0.8; // Zoom (0.5 terlalu jauh)

                // --- Animasi dari script Anda ---
                skinViewer.animation = new skinview3d.WalkingAnimation();
                skinViewer.animation.speed = 1; // Speed (3 terlalu cepat)

                // --- Logika Load Skin Dinamis ---
                // Cek jika user punya skin di storage, jika tidak, pakai gamertag
                @if ($user->skin)
                    // Prioritas 1: Load skin dari storage jika ada
                    skinViewer.loadSkin('{{ asset('storage/' . $user->skin) }}');
                @else
                    // Cadangan: Load skin dari gamertag jika tidak ada skin di-upload
                    skinViewer.loadSkin('https://minotar.net/skin/{{ $user->gamertag }}');
                @endif

                // --- Kontrol (Opsional, tapi bagus) ---
                // Biarkan user bisa memutar manual meski sudah autoRotate
                let control = skinview3d.createOrbitControls(skinViewer);
                control.enableZoom = false; // Matikan zoom

                // Simpan referensi ke canvas agar tidak inisialisasi ulang
                canvas.skinViewer = skinViewer;
            }
        }
    </script>
