<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'rekam_medis_id',
        'title',
        'fullname',
        'date_of_birth',
        'gender',
        'phone_number',
        'dokter_id',
        'service_unit_id',
        'appointment_at',
        'no_antrian',
        'data_status',
        'kunjungan_pasien_id',
        'keterangan'
    ];
}
