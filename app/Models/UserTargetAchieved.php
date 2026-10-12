<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTargetAchieved extends Model
{
    protected $table = 'user_target_achieveds';

    protected $fillable = [
        'employ_id',
        'role_id',
        'indicator_id',
        'year_id',
        'target',
        'acheived',
        'status',
    ];
}
