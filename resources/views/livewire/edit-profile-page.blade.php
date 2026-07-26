<div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form wire:submit="save">
                <div class="overflow-hidden bg-white shadow-lg dark:bg-zinc-900 sm:rounded-lg border dark:border-zinc-700">
                    <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-3">

                        {{-- KOLOM KIRI: INFO DASAR (Pakai Flux UI) --}}
                        <div class="space-y-6 md:col-span-2">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Informasi Profil</h3>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                Perbarui informasi dasar akun Anda.
                            </p>

                            <flux:field>
                                <flux:label>Nama Lengkap</flux:label>
                                <flux:input wire:model="name" type="text" />
                                <flux:error name="name" />
                            </flux:field>
                            
                            <flux:field>
                                <flux:label>Email</flux:label>
                                <flux:input wire:model="email" type="email" />
                                <flux:error name="email" />
                            </flux:field>

                            <flux:field>
                                <flux:label>Gamertag</flux:label>
                                <flux:input wire:model="gamertag" type="text" />
                                <flux:error name="gamertag" />
                            </flux:field>

                            <flux:field>
                                <flux:label>No. Telepon/WA</flux:label>
                                <flux:input wire:model="phone" type="tel" />
                                <flux:error name="phone" />
                            </flux:field>
                        </div>

                        {{-- KOLOM KANAN: UPLOAD (Pakai Tailwind Kustom) --}}
                        <div class="space-y-6 md:col-span-1">
                            
                            {{-- UPLOAD AVATAR (Kustom) --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Avatar</label>
                                <div class="p-4 mt-1 bg-zinc-50 border-2 border-zinc-300 border-dashed rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                                    <div class="flex items-center space-x-4">
                                        {{-- Preview --}}
                                        @if ($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" class="w-16 h-16 rounded-md">
                                        @elseif ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-16 h-16 rounded-md">
                                        @else
                                            <div class="flex items-center justify-center w-16 h-16 bg-zinc-200 rounded-md dark:bg-zinc-600">
                                                <svg class="w-8 h-8 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.5 1.5 0 0 1 18 21.75H6a1.5 1.5 0 0 1-1.499-1.632Z" /></svg>
                                            </div>
                                        @endif
                                        <label for="avatar_upload" class="px-3 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-md shadow-sm cursor-pointer dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                            <span>Ganti</span>
                                            <input id="avatar_upload" wire:model="avatar" type="file" class="sr-only">
                                        </label>
                                        {{-- Tombol Hapus Preview --}}
                                        @if ($avatar)
                                        <button type="button" wire:click="clearUpload('avatar')" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                        </button>
                                        @endif
                                    </div>
                                    @error('avatar') <span class="mt-2 text-sm text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- UPLOAD SKIN (Kustom) --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Skin (.PNG)</label>
                                <div class="p-4 mt-1 bg-zinc-50 border-2 border-zinc-300 border-dashed rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                                    <div class="flex items-center space-x-4">
                                        {{-- Preview --}}
                                        @if ($skin)
                                            <img src="{{ $skin->temporaryUrl() }}" class="object-contain w-16 h-16 p-1 bg-zinc-200 rounded-md dark:bg-zinc-600">
                                        @elseif ($user->skin)
                                            <img src="{{ asset('storage/' . $user->skin) }}" class="object-contain w-16 h-16 p-1 bg-zinc-200 rounded-md dark:bg-zinc-600">
                                        @else
                                            <div class="flex items-center justify-center w-16 h-16 bg-zinc-200 rounded-md dark:bg-zinc-600">
                                                <svg class="w-8 h-8 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm1.5-6.75h.008v.008H3.75v-.008Zm0 3h.008v.008H3.75v-.008Zm0 3h.008v.008H3.75v-.008Z" /></svg>
                                            </div>
                                        @endif
                                        <label for="skin_upload" class="px-3 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-md shadow-sm cursor-pointer dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                            <span>Ganti</span>
                                            <input id="skin_upload" wire:model="skin" type="file" class="sr-only">
                                        </label>
                                        {{-- Tombol Hapus Preview --}}
                                        @if ($skin)
                                        <button type="button" wire:click="clearUpload('skin')" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                                        </button>
                                        @endif
                                    </div>
                                    @error('skin') <span class="mt-2 text-sm text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    {{-- FOOTER AKSI --}}
                    <div class="flex items-center justify-end gap-4 px-6 py-4 bg-zinc-50 dark:bg-zinc-900">
                        <div wire:loading wire:target="save" class="text-sm text-zinc-500 dark:text-zinc-400">
                            Menyimpan...
                        </div>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-md shadow-sm dark:bg-zinc-700 dark:text-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-600">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>