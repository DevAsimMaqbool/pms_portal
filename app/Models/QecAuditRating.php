<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QecAuditRating extends Model
{
    protected $fillable = [
        'indicator_id',
        'audit_term',
        'faculty_id',
        'department_id',
        'program_id',
        'program_level',
        'total_score',
        'obtained_score',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
