<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarsSatisfactionInThesisStage extends Model
{
    protected $fillable = [
        'indicator_id',
        'faculty_id',
        'department_id',
        'program_id',
        'term',
        'career',
        'satisfaction_score',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
