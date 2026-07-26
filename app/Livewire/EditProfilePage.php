<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class EditProfilePage extends Component
{
    use WithFileUploads;
    #[Title('Oxydius Member - Edit Profile')] 

    public ?User $user;

    // --- Properti untuk Form Data ---
    public string $name = '';
    public string $email = '';
    public string $gamertag = '';
    public string $phone = '';
    public $avatar; // Untuk upload
    public $skin; // Untuk upload

    public function mount()
    {
        $this->user = Auth::user();
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->gamertag = $this->user->gamertag;
        $this->phone = $this->user->phone ?? '';
    }

    public function save(): void
    {
        // Validasi data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'gamertag' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'avatar' => 'nullable|image|max:2048',
            'skin' => 'nullable|image|mimes:png|max:2048',
        ]);

        $profileData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'gamertag' => $validatedData['gamertag'],
            'phone' => $validatedData['phone'],
        ];

        // Simpan file jika ada yang di-upload
        if ($this->avatar) {
            $profileData['avatar'] = $this->avatar->store('avatars', 'public');
        }
        
        if ($this->skin) {
            $profileData['skin'] = $this->skin->store('skins', 'public');
        }

        // Update data user
        $this->user->update($profileData);

        session()->flash('success', 'Profil berhasil diperbarui!');
        $this->redirect(route('dashboard'));
    }

    /**
     * Method untuk menghapus file preview (Temporary Upload).
     */
    public function clearUpload($field)
    {
        $this->reset($field);
        $this->resetErrorBag($field);
    }

    public function render()
    {
        return view('livewire.edit-profile-page');
    }
}