<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyEngagementDepartment extends Model
{
    protected $table = 'faculty_engagement_departments'; // explicit table name
    protected $fillable = [
        'indicator_id',
        'total_faculty_in_department',
        'faculty_actively_engaged',
        'types_of_engagement',
        'evidence_reference',
        'remarks',
        'faculty_engagement_percentage',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
    protected $casts = [
        'types_of_engagement' => 'array',
    ];
}
