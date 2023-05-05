<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    protected $fillable = [
        'jurnal_at',
        'no_bukti',
        'customer_id',
        'supplier_id',
        'keterangan',
        'data_status',
        'created_by',
        'ammend_by',
        'edit_by',
        'approved_by',
        'delivered_by',
        'received_by',
        'ammend_at',
        'edit_at',
        'approved_at',
        'delivered_at',
        'received_at'
    ];
}
