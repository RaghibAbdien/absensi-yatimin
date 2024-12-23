<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function presensis()
    {
        return $this->hasMany(Presensi::class, 'pengguna_id');
    }
}
