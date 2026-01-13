<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyRetention extends Model
{

    protected $fillable = [
        'indicator_id',
        'form_status',
        'academic_year',
        'faculty_id',
        'department_id',
        'strength_at_start_of_month',
        'join_during_month',
        'left_during_month',
        'strength_end_month',
        'retention_rate',
        'retention_status',
        'remarks',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
}
