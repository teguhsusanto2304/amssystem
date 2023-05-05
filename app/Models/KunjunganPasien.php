<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganPasien extends Model
{
    use HasFactory;
    protected $fillable = ['id',
    'rekam_medis_id',
    'dokter_id',
    'service_unit_id',
    'penjamin_id',
    'penanggungjawab_id',
    'jenis_kunjungan_id',
    'jenis_perawatan_id',
    'kunjungan_at',
    'no_antrian',
    'data_status',
    'no_registrasi'];
}
