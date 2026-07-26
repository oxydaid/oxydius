<x-filament-panels::page>
    {{-- 
      wire:submit="save" akan memanggil method save()
      di class Settings.php saat form di-submit 
    --}}
    <form wire:submit="save">
        {{-- Render form yang kita buat di Settings.php --}}
        {{ $this->form }}

        {{-- Render tombol aksi (Save) --}}
        <div class="mt-6">
            <x-filament::button
                type="submit"
                size="lg"
            >
                Simpan Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>