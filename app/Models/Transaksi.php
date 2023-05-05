<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'id',          
            'kunjungan_pasien_id',
            'transaksi_at',
            'service_unit_id',
            'no_antrian',
            'no_transaksi',
            'data_status',
            'total'
    ];
}
