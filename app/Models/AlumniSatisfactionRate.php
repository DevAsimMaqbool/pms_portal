<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniSatisfactionRate extends Model
{
    protected $fillable = [
        'indicator_id',
        'name',
        'gender',
        'faculty_id',
        'department_id',
        'program_id',
        'program_level',
        'roll_no',
        'graduation_year',
        'current_organization',
        'current_designation',
        'current_salary',
        'email',
        'satisfaction_rate',
        'form_status',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
