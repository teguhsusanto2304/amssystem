<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananServiceUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'layanan_id',
        'service_unit_id',
        'data_status'
    ];
}
