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
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    // Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Program
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
