<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEngagementRate extends Model
{
    protected $table = 'student_engagement_rate';
    protected $fillable = [
        'indicator_id',
        'nature_of_event',
        'other_event_detail',
        'event_location',
        'scope_of_the_event',
        'title_of_the_event',
        'brief_description_of_activity',
        'faculty_id',
        'department_id',
        'program_id',
        'participation_target',
        'number_of_students_participated',
        'employer_satisfaction',
        'event_start_date',
        'event_end_date',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
     protected $casts = [
        'event_location' => 'array',
    ];
}
