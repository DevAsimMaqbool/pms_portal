<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectRankingTarget extends Model
{
    protected $fillable = [
        'indicator_id',
        'form_status',
        'academic_year',
        'faculty_id',
        'department_id',
        'subject_id',
        'ranking_body',
        'targeted_ranking_range',
        'actual_ranking_achieved',
        'ranking_status',
        'evidence_upload',
        'remarks',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
}
