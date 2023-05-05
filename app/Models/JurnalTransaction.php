<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'jurnal_id',
        'kode_rekening_id',
        'debit',
        'kredit',
        'data_status'
    ];
}
