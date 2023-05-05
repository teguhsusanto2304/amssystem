<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterServiceUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'service_unit_id',
        'data_status'
    ];
}
