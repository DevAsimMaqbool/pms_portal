<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employability extends Model
{
    protected $fillable = [
        'student_id',
        'secure_job',
        'job_relevancy',
        'salary',
        'job_nature',
        'joining_date',
        'created_by',
        'updated_by'
    ];
}
