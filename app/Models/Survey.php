<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'survey',
        'campus',
        'institute',
        'department',
        'career',
        'program',
        'batch',
        'faculty',
        'class',
        'course',
        'section',
        'question',
        'answer_type',
        'student_id',
        'answer',
        'faculty_code',
        'inserted_at',
    ];
}
