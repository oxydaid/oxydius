<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        // Otomatis konversi JSON ke array (saat ambil)
        // dan array ke JSON (saat simpan)
        'application_data' => 'array',
        
        // Otomatis hash password saat disimpan
        'password' => 'hashed', 
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
