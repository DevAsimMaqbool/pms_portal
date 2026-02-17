<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    protected $fillable = [
        'indicator_id',
        'faculty_id',
        'department_id',
        'program_id',
        'target_month_year',
        'recovery_target',
        'achieved_target',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
