<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatisfactionOfInternationalStudent extends Model
{
    protected $fillable = [
        'indicator_id',
        'student_name',
        'student_roll_no',
        'faculty_id',
        'department_id',
        'program_id',
        'program_level',
        'student_country',
        'student_semester',
        'student_rating',
        'student_comments',
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
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
