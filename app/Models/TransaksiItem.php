<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'kunjungan_pasien_id',
        'transaksi_id',
        'transaksi_at',
        'service_unit_id',
        'dokter_id',
        'layanan_id',
        'tarif',
        'qty',
        'discount_prosen',
        'discount_nominal',
        'is_diskon',
        'sub_total',
        'no_antrian',
        'no_transaksi',
        'data_status'
    ];
}
