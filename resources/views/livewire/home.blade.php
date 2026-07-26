<div>
    <!-- ===== Hero Section (Background Image + Overlay) ===== -->
    <header class="relative w-full bg-cover bg-center" style="background-image: url('{{ $settings->hero_background ? asset('storage/' . $settings->hero_background) : 'https://source.unsplash.com/1600x900/?minecraft,fantasy' }}');">
        
        <!-- Overlay (Hanya Dark) -->
        <div class="absolute inset-0 z-0 w-full h-full bg-zinc-900/80"></div>
        
        <!-- Konten Hero -->
        <div class="container relative z-10 px-6 py-24 mx-auto lg:py-32">
            <div class="flex items-center justify-center w-full">
                <div class="max-w-2xl text-center">
                    <h1 class="text-4xl font-black text-white lg:text-6xl">Bangun, Bertahan, Taklukkan.</h1>
                    <p class="mt-4 text-lg text-zinc-200">Bergabunglah dengan <span class="font-bold text-transparent bg-clip-text bg-linear-to-r from-green-500 to-emerald-600">Oxydius</span>, Clan server Minecraft ProwNetwork terdedikasi untuk player yang ramah dan kreatif.</p>
                    <a href="#cta" class="inline-block px-6 py-3 mt-8 text-lg font-medium text-white transition-all duration-300 transform rounded-lg shadow-xl bg-linear-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:scale-105">
                        Gabung Sekarang!
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== Divisi Section (DINAMIS) ===== -->
    <section id="divisi" class="py-16 bg-zinc-800">
        <div class="container px-6 mx-auto">
            <h2 class="text-3xl font-bold text-center text-white capitalize lg:text-4xl">Divisi Kami</h2>
            <p class="max-w-2xl mx-auto mt-4 text-center text-zinc-300">
                Temukan passion Anda. Setiap anggota memiliki peran penting dalam clan.
            </p>
            <div class="grid grid-cols-1 gap-8 mt-12 md:grid-cols-2 lg:grid-cols-4">
                @forelse($divisions as $division)
                <a href="{{ route('division', $division->slug) }}">
                    <div class="flex flex-col items-center p-6 text-center transition-transform transform bg-zinc-700 rounded-lg shadow-lg hover:scale-105">
                        <img class="object-cover w-24 h-24 rounded-lg" 
                             src="{{ $division->icon ? asset('storage/' . $division->icon) : 'https://placehold.co/100x100/22c55e/ffffff?text=' . $division->name }}" 
                             alt="{{ $division->name }} Icon">
                        <h3 class="mt-4 text-2xl font-semibold text-white">{{ $division->name }}</h3>
                        <p class="mt-2 text-zinc-300">{{ $division->description }}</p>
                    </div>
                </a>
                @empty
                    <p class="text-center text-zinc-400 md:col-span-4">Data divisi sedang disiapkan...</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===== Anggota Section (DINAMIS) ===== -->
    <section id="anggota" class="py-16 bg-zinc-900">
        <div class="container px-6 mx-auto">
            <h2 class="text-3xl font-bold text-center text-white capitalize lg:text-4xl">Petinggi Clan</h2>
            <p class="max-w-2xl mx-auto mt-4 text-center text-zinc-300">
                Temui tim inti yang mengelola dan memajukan clan setiap hari.
            </p>
            <div class="grid grid-cols-1 gap-8 mt-12 md:grid-cols-2 lg:grid-cols-4">
                @forelse($leaders as $leader)
                    {{-- 
                      --- SOLUSI STABIL: ALPINE.JS ---
                      Fungsi 'initSingleSkinViewer' dipanggil dari layout <head> Anda.
                    --}}
                    <div class="p-6 text-center bg-zinc-800 rounded-lg shadow-lg"
                         x-data="{ 
                             gamertag: '{{ $leader->user->gamertag }}',
                             skinUrl: '{{ $leader->user->skin ? asset('storage/' . $leader->user->skin) : '' }}'
                         }"
                         x-init="initSingleSkinViewer($el.querySelector('.skin-renderer'), gamertag, skinUrl)"
                    >
                        <canvas class="mx-auto h-64 skin-renderer" 
                                wire:key="skin-{{ $leader->id }}">
                        </canvas>
                        <a href="{{ route('user-profile', $leader->user->gamertag) }}">
                            <h3 class="mt-4 text-2xl font-semibold bg-linear-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">
                                {{ $leader->user->gamertag }}
                            </h3>
                        </a>
                        
                        <p class="mt-1 font-medium text-zinc-300">{{ $leader->position }}</p>
                        <p class="mt-0.5 text-sm text-zinc-400">{{ $leader->division?->name ?? 'Tim Inti' }}</p>
                    </div>
                @empty
                    <p class="text-center text-zinc-400 md:col-span-4">Data petinggi clan sedang disiapkan...</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===== Section 4: Gallery (Carousel) - BARU ===== -->
    @if($galleries->count() > 0)
    <section id="gallery" class="py-16 text-white bg-zinc-900 overflow-hidden">
        <div class="container px-6 mx-auto">
            <h2 class="text-3xl font-bold text-center text-white capitalize lg:text-4xl mb-12">
                Dokumentasi Clan
            </h2>

            <!-- Carousel Container dengan Alpine.js -->
            <div x-data="{ 
                    activeSlide: 0,
                    slides: {{ $galleries->count() }},
                    next() {
                        this.activeSlide = (this.activeSlide === this.slides - 1) ? 0 : this.activeSlide + 1
                    },
                    prev() {
                        this.activeSlide = (this.activeSlide === 0) ? this.slides - 1 : this.activeSlide - 1
                    },
                    init() {
                        // Auto-play setiap 5 detik
                        setInterval(() => { this.next() }, 5000);
                    }
                }" 
                class="relative w-full max-w-5xl mx-auto"
            >
                <!-- Slides Wrapper -->
                <div class="relative h-64 w-full overflow-hidden rounded-2xl shadow-xl md:h-96 lg:h-[500px]">
                    @foreach($galleries as $index => $gallery)
                        <!-- Single Slide -->
                        <div x-show="activeSlide === {{ $index }}"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute inset-0 w-full h-full"
                        >
                            {{-- PENTING: asset('storage/'...) hanya berfungsi jika storage:link sudah dijalankan --}}
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                 alt="{{ $gallery->title ?? 'Dokumentasi Clan' }}" 
                                 class="object-cover w-full h-full"
                            >
                            
                            <!-- Caption Overlay -->
                            @if($gallery->title || $gallery->description)
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white bg-linear-to-t from-black/90 via-black/50 to-transparent">
                                    @if($gallery->title)
                                        <h3 class="text-xl font-bold">{{ $gallery->title }}</h3>
                                    @endif
                                    @if($gallery->description)
                                        <p class="mt-1 text-sm text-zinc-300 line-clamp-2">{{ $gallery->description }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Navigasi (Prev/Next) -->
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 p-2 text-white transition-colors rounded-full backdrop-blur-sm bg-black/30 hover:bg-black/50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-white transition-colors rounded-full backdrop-blur-sm bg-black/30 hover:bg-black/50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>

                <!-- Indikator (Dots) -->
                <div class="absolute bottom-4 left-1/2 flex space-x-2 -translate-x-1/2">
                    @foreach($galleries as $index => $gallery)
                        <button @click="activeSlide = {{ $index }}" 
                                :class="activeSlide === {{ $index }} ? 'bg-white w-6' : 'bg-white/50 w-2 hover:bg-white/80'"
                                class="h-2 transition-all duration-300 rounded-full"
                                aria-label="Go to slide {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ===== Call to Action (CTA) Section ===== -->
    <section id="cta" class="py-16 bg-linear-to-r from-green-500 to-emerald-600">
        <div class="container px-6 mx-auto text-center">
            <h2 class="text-4xl font-bold text-white">
                Siap Bergabung?
            </h2>
            <p class="max-w-xl mx-auto mt-4 text-lg text-green-50">
                Kami sedang membuka pendaftaran untuk anggota baru yang berdedikasi. Klik tombol di bawah untuk mengisi formulir pendaftaran.
            </p> {{-- <-- Perbaikan: Tag </Ulasan> yang salah sudah dihapus/diperbaiki --}}
            
            {{-- TODO: Ganti '#' dengan rute pendaftaran nanti --}}
            <a href="{{ route('register-member')  }}" class="inline-block px-8 py-3 mt-8 text-lg font-medium text-primary-700 transition-colors duration-300 transform bg-white rounded-lg shadow-lg hover:bg-zinc-100">
                Daftar Anggota Clan Oxydius
            </a>
        </div>
    </section>
</div>