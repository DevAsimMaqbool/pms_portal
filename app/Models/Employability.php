<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employability extends Model
{
    protected $fillable = [
        'indicator_id',
        'student_id',
        'faculty_id',
        'program_id',
        'batch',
        'passing_year',
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
}
