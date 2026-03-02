<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustrialVisit extends Model
{
    protected $fillable = [
        'indicator_id',
        'form_status',
        'employee_name',
        'employee_id',
        'designation',
        'department_program',
        'campus_unit',
        'industry_organization',
        'industry_sector',
        'purpose_learning_objective',
        'course_subject',
        'students_involved',
        'employee_role',
        'visit_category',
        'evidence_upload',
        'visit_start_date',
        'visit_end_date',
        'location',
        'visit_report_submitted',
        'report_submission_date',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
     protected $casts = [
        'update_history' => 'array',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
