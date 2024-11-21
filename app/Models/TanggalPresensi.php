<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalPresensi extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal'];

    public function presensis()
    {
        return $this->hasMany(Presensi::class, 'tanggal_id');
    }
}
