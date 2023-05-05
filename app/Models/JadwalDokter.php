<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;
    protected $fillable = ['doctor_id','hari','index_hari','jam_mulai','jam_akhir'];
}
