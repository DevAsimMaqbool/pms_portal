<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employability extends Model
{
    protected $fillable = [
        'student_id',
        'faculty_id',
        'program_id',
        'batch_id',
        'passing_year',
        'employer_name',
        'sector',
        'salary',
        'market_competitive_salary',
        'rob_relevancy',
        'employer_satisfaction',
        'graduate_satisfaction',
        'created_by',
        'updated_by'
    ];
}
