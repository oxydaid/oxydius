<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    Use HasFactory;
    protected $guarded = ["id"];

    public function members()
    {
        return $this->hasMany(ClanMember::class);
    }

}
