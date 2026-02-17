<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionTargetAchieved extends Model
{

    protected $fillable = [
        'faculty_id',
        'department_id',
        'program_id',
        'admissions_campaign',
        'admissions_target',
        'achieved_target',
        'form_status',
        'indicator_id',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
