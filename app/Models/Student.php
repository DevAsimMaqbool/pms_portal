<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'roll_number',
        'full_name',
        'father_name',
        'email',
        'cnic',
        'mobile_number',
        'email_verified_at',
        'password',
        'profile_image',
        'two_factor_code',
        'two_factor_expires_at',
        'remember_token',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
