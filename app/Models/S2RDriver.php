<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class S2RDriver extends Model
{
     protected $table = 's2_r_drivers';
    protected $fillable = [
        'driver_name',
        'slug',
        'status'
    ];
}
