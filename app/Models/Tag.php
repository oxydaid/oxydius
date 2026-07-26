<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ["id"];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
