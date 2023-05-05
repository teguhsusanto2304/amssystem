<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = ['medic_code',
    'front_title','fullname',
    'back_title','date_of_birth','gender','address','phone_number',
    'speciality_id','service_unit_id',
    'data_status'];
}
