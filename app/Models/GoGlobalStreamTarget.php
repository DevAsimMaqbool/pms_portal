<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoGlobalStreamTarget extends Model
{
    protected $fillable = [
        'indicator_id',
        'faculty_id',
        'department_id',
        'program_id',
        'experience_target',
        'achieved_target',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
