<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatisfactionOfInternationalStudent extends Model
{
    protected $fillable = [
        'indicator_id',
        'student_name',
        'student_roll_no',
        'student_program',
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
}
