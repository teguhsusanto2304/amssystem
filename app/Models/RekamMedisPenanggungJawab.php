<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisPenanggungJawab extends Model
{
    use HasFactory;
    public function rekam_medis(){
        return $this->belongsTo('App\Models\RekamMedis','rekam_medis_id');
    }
}
