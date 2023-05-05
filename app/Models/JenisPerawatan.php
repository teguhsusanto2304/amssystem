<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPerawatan extends Model
{
    use HasFactory;
    protected $fillable=[
        'jenis_perawatan',
        'data_status'
    ];
}
