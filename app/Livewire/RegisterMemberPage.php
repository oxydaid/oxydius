<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Division;
use App\Models\AppSetting;
use App\Models\Registration;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app.home', ['description' => 'Bergabunglah dengan Oxydius, komunitas server Minecraft terdedikasi untuk player yang serius dan kreatif. Bangun, bertahan, dan taklukkan bersama kami.'])] // Menggunakan layout 'guest' (dark mode)
#[Title('Oxydius - Pendaftaran Anggota')] 
class RegisterMemberPage extends Component
{
    // Properti data pendaftaran
    public $divisions = [];
    public $settings;
    public $name = '';
    public $email = '';
    public $gamertag = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $division_id = '';
    
    // Properti untuk data JSON
    public $reason = '';
    public $agree_rules = false;
    public $agree_cooperate = false;
    public $contribution = '';
    public $other_skills = '';

    // Status form
    public $success = false;

    public function mount()
    {
        $this->settings = AppSetting::find(1);
        // Ambil data divisi untuk dropdown
        $this->divisions = Division::where('name', '!=', 'Core')
                                 ->orderBy('name')
                                 ->get();
    }

    /**
     * Simpan pendaftaran.
     */
    public function save()
    {
    if (!$this->settings || !$this->settings->is_open_member) {
            session()->flash('error', 'Pendaftaran ditutup sementara oleh admin.');
            return;
        }
        
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email'), // Unik di tabel users
                Rule::unique('registrations', 'email') // Unik di tabel registrations
            ],
            'gamertag' => [
                'required', 'string', 'max:255',
                Rule::unique('users', 'gamertag'),
                Rule::unique('registrations', 'gamertag')
            ],
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'division_id' => 'required|exists:divisions,id',
            
            // Validasi data JSON
            'reason' => 'required|string|min:10|max:1000',
            'contribution' => 'required|string|min:10|max:1000',
            'other_skills' => 'nullable|string|max:1000',
            'agree_rules' => 'accepted', // Harus true
            'agree_cooperate' => 'accepted', // Harus true
        ]);

        // Gabungkan data JSON
        $applicationData = [
            'reason' => $this->reason,
            'contribution' => $this->contribution,
            'other_skills' => $this->other_skills,
            'agree_rules' => $this->agree_rules,
            'agree_cooperate' => $this->agree_cooperate,
        ];

        // Buat data pendaftaran
        Registration::create([
            'name' => $this->name,
            'email' => $this->email,
            'gamertag' => $this->gamertag,
            'phone' => $this->phone,
            'password' => $this->password, // Model akan auto-hash
            'division_id' => $this->division_id,
            'application_data' => $applicationData,
            'status' => 'pending',
        ]);

        // Set status sukses
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.register-member-page');
    }
}