<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;
    protected $fillable = [
    'medical_record_no',
    'title',
    'fullname',
    'date_of_birth',
    'gender',
    'address',
    'province_id',
    'city_id',
    'postal_code',
    'phone_number',
    'blood_type',
    'identity_type',
    'identity_number',
    'data_status'];
    public function penanggung_jawab(){
        return $this->hasMany('App\Models\RekamMedisPenanggungJawab','rekam_medis_id');
    }
    public function penjamin(){
        return $this->hasMany('App\Models\RekamMedisPenjamin','rekam_medis_id');
    }
}
