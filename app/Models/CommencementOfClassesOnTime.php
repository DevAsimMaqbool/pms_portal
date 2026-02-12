<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommencementOfClassesOnTime extends Model
{
    protected $fillable = [
        'indicator_id',
        'faculty_id',
        'department_id',
        'program_level',
        'classes_observed',
        'classes_on_time',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
