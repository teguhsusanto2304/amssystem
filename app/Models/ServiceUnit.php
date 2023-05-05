<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_unit',
        'speciality_id',
        'data_status',
        'tipe_service_unit'
    ];
}
