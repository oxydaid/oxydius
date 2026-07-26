<header x-data="{ open: false }" class="sticky top-0 z-50 w-full bg-zinc-800 shadow-md border-b border-zinc-700">
    <nav class="container flex items-center justify-between px-6 py-4 mx-auto">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('img/logo.png') }}" class="h-10" alt="">
            <a href="{{ route('home') }}" class="text-xl font-bold text-white lg:text-2xl hover:text-primary-600 hover:text-primary-500">
                Oxydius
            </a>
        </div>

        <!-- Desktop Menu -->
        <div class="items-center hidden space-x-6 md:flex">
            <a href="{{ route('all-divisions') }}" class="text-sm font-medium text-zinc-200 hover:text-primary-500 transition">Divisi</a>
            <a href="{{ route('all-members') }}" class="text-sm font-medium text-zinc-200 hover:text-primary-500 transition">Anggota</a>
            <a href="{{ route('all-gallery') }}" class="text-sm font-medium text-zinc-200 hover:text-primary-500 transition">Galeri</a>
            
            @auth
                <a href="{{ route('dashboard') }}" class="w-full px-4 py-2 text-sm font-medium text-center text-white transition-all duration-300 transform rounded-md bg-linear-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 shadow-lg md:w-auto">
                    Dashboard
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="w-full px-4 py-2 text-sm font-medium text-center text-white transition-all duration-300 transform rounded-md bg-linear-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 shadow-lg md:w-auto">
                    Login
                </a>
            @endauth
        </div>
        
        <!-- Mobile Menu Button -->
        <button @click="open = !open" class="md:hidden text-zinc-300 focus:outline-none">
              <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
              <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </nav>
    
    <!-- Mobile Menu -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="absolute w-full md:hidden bg-zinc-800 border-t border-zinc-700 shadow-lg"
         style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('all-divisions') }}" @click="open = false" class="block px-3 py-2 text-base font-medium rounded-md text-zinc-300 hover:text-white hover:bg-primary-600">Divisi</a>
            <a href="{{ route('all-members') }}" @click="open = false" class="block px-3 py-2 text-base font-medium rounded-md text-zinc-300 hover:text-white hover:bg-primary-600">Anggota</a>
            <a href="{{ route('all-gallery') }}" @click="open = false" class="block px-3 py-2 text-base font-medium rounded-md text-zinc-300 hover:text-white hover:bg-primary-600">Galeri</a>
            
            <hr class="border-zinc-700">

            @auth
                <a href="{{ route('dashboard') }}" @click="open = false" class="block px-3 py-2 text-base font-medium rounded-md text-zinc-300 hover:text-white hover:bg-primary-600">Dashboard</a>
            @else
                <a href="{{ route('dashboard') }}" @click="open = false" class="block px-3 py-2 text-base font-medium rounded-md text-zinc-300 hover:text-white hover:bg-primary-600">Login</a>
            @endauth
        </div>
    </div>
</header>