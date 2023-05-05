<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_layanan',
        'nama_layanan',
        'kode_rekening_id',
        'group_layanan_id',
        'jasa_dokter_id',
        'data_status',
        'merger_layanan_id'
    ];

}
