<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_ruang',
        'kode_ruang',
        'service_unit_id'
    ];
}
