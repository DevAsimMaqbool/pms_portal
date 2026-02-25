<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employability extends Model
{
    protected $fillable = [
        'indicator_id',
        'student_id',
        'student_name',
        'faculty_id',
        'department_id',
        'program_id',
        'period',
        'batch',
        'passing_year',
        'date_of_appointment',
        'proof_salary_and_appointment',
        'employer_name',
        'sector',
        'salary',
        'market_competitive_salary',
        'job_relevancy',
        'employer_satisfaction',
        'graduate_satisfaction',
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
}
