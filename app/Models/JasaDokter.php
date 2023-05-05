<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasaDokter extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_jasa_dokter',
        'prosentase_jasa_dokter',
        'prosentase_rumah_sakit',
        'data_status'
    ];
}
