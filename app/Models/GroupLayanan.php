<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupLayanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_layanan',
        'service_unit_id',
        'data_status'
    ];
}
