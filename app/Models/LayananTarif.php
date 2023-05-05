<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananTarif extends Model
{
    use HasFactory;
    protected $fillable = [
        'layanan_id',
        'kelas_id',
        'tarif',
        'diskon',
        'data_status'
    ];
}
