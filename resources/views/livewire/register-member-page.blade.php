<div>

    <div class="container px-6 py-12 mx-auto">
        
        {{-- KONDISI 1: Pendaftaran Ditutup --}}
        @if (!$settings || !$settings->is_open_member)
            <div class="w-full max-w-2xl p-8 mx-auto text-center bg-red-900/50 border border-red-700 rounded-lg shadow-lg">
                <img class="w-16 h-16 mx-auto" src="{{ asset('img/barrier.webp') }}" alt="barrier">
                <h2 class="mt-6 text-3xl font-bold text-red-200">Pendaftaran Ditutup Sementara</h2>
                <p class="mt-4 text-lg text-red-300">
                    Mohon maaf, admin memutuskan untuk menutup pendaftaran. Silakan cek discord ProwNetwork pada bagian <strong>promote-clan</strong> secara berkala!
                </p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-3 mt-8 text-lg font-medium text-white transition-all duration-300 transform rounded-lg shadow-xl bg-linear-to-r from-zinc-600 to-zinc-700 hover:from-zinc-700 hover:to-zinc-800 hover:scale-105">
                    Kembali ke Home
                </a>
            </div>

        {{-- KONDISI 2: Form Sukses Terkirim --}}
        @elseif ($success)
            <div class="w-full max-w-2xl p-8 mx-auto text-center bg-zinc-800 rounded-lg shadow-lg">
                <svg class="w-16 h-16 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h2 class="mt-6 text-3xl font-bold text-white">Pendaftaran Terkirim!</h2>
                <p class="mt-4 text-lg text-zinc-300">
                    Data Anda akan segera di-review oleh admin. Terima kasih telah mendaftar!
                </p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-3 mt-8 text-lg font-medium text-white transition-all duration-300 transform rounded-lg shadow-xl bg-linear-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:scale-105">
                    Kembali ke Home
                </a>
            </div>

        {{-- KONDISI 3: Form Aktif (Default) --}}
        @else
            <form wire:submit="save" class="w-full max-w-4xl p-8 mx-auto bg-zinc-800 rounded-lg shadow-lg ">
                <h2 class="text-3xl font-bold text-center text-white">Formulir Pendaftaran</h2>
                <p class="mt-2 text-center text-zinc-400">Isi data di bawah ini untuk bergabung dengan Oxydius.</p>
                
                {{-- Loading Indicator --}}
                <div wire:loading wire:target="save" class="w-full my-4 p-3 text-center text-blue-300 bg-blue-900/50 rounded-lg">
                    Mengirim pendaftaran...
                </div>

                <fieldset class="mt-8">
                    <legend class="text-xl font-semibold text-white">Data Akun</legend>
                    <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-zinc-300">Nama Lengkap</label>
                            <input type="text" wire:model.blur="name" id="name" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                            @error('name') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="gamertag" class="block text-sm font-medium text-zinc-300">Gamertag Minecraft</label>
                            <input type="text" wire:model.blur="gamertag" id="gamertag" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                            @error('gamertag') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-zinc-300">Alamat Email</label>
                            <input type="email" wire:model.blur="email" id="email" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                            @error('email') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-zinc-300">No. Telepon/WA (Opsional)</label>
                            <input type="tel" wire:model.blur="phone" id="phone" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                            @error('phone') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-zinc-300">Password</label>
                            <input type="password" wire:model.blur="password" id="password" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                            @error('password') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-zinc-300">Konfirmasi Password</label>
                            <input type="password" wire:model.blur="password_confirmation" id="password_confirmation" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                </fieldset>

                <fieldset class="mt-8">
                    <legend class="text-xl font-semibold text-white">Data Pendaftaran</legend>
                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <div>
                            <label for="division_id" class="block text-sm font-medium text-zinc-300">Divisi yang Dipilih</label>
                            <select wire:model.blur="division_id" id="division_id" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                            @error('division_id') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="reason" class="block text-sm font-medium text-zinc-300">Apa alasan Anda ingin bergabung?</label>
                            <textarea wire:model.blur="reason" id="reason" rows="3" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            @error('reason') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="contribution" class="block text-sm font-medium text-zinc-300">Apa kontribusi yang bisa Anda berikan untuk clan?</label>
                            <textarea wire:model.blur="contribution" id="contribution" rows="3" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            @error('contribution') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="other_skills" class="block text-sm font-medium text-zinc-300">Kemampuan lain di luar divisi (Opsional)</label>
                            <textarea wire:model.blur="other_skills" id="other_skills" rows="2" class="block w-full mt-1 bg-zinc-700 border-zinc-600 rounded-md shadow-sm text-white focus:border-green-500 focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            @error('other_skills') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <input id="agree_rules" wire:model.blur="agree_rules" type="checkbox" class="w-4 h-4 mt-1 text-green-600 bg-zinc-700 border-zinc-600 rounded focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                                <label for="agree_rules" class="ml-3 block text-sm text-zinc-300">
                                    Saya setuju untuk mematuhi semua aturan clan yang berlaku.
                                </label>
                            </div>
                            @error('agree_rules') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                            
                            <div class="flex items-start">
                                <input id="agree_cooperate" wire:model.blur="agree_cooperate" type="checkbox" class="w-4 h-4 mt-1 text-green-600 bg-zinc-700 border-zinc-600 rounded focus:ring-green-500 py-2 px-3 border leading-tight focus:outline-none focus:shadow-outline">
                                <label for="agree_cooperate" class="ml-3 block text-sm text-zinc-300">
                                    Saya bersedia untuk aktif dan bekerjasama dengan anggota clan lain.
                                </label>
                            </div>
                            @error('agree_cooperate') <span class="text-sm text-red-400">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </fieldset>

                <div class="mt-8 text-right">
                    <button type="submit" class="inline-block px-8 py-3 text-lg font-medium text-white transition-all duration-300 transform rounded-lg shadow-xl bg-linear-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:scale-105">
                        Kirim Pendaftaran
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>