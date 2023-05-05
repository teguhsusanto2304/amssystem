<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'kunjungan_pasien_id',
        'transaksi_id',
        'transaksi_at',
        'service_unit_id',
        'dokter_id',
        'barang_id',
        'satuan_barang_id',
        'service_unit_id',
        'tarif',
        'qty',
        'discount_prosen',
        'discount_nominal',
        'is_diskon',
        'sub_total',
        'no_antrian',
        'no_transaksi'
    ];
    
}
