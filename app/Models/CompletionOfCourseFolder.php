<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletionOfCourseFolder extends Model
{
    protected $fillable = [
        'faculty_member_id',
        'class_cod',
        'form_status',
        'completion_of_Course_folder',
        'completion_of_Course_folder_indicator_id',
        'compliance_and_usage_of_lms',
        'compliance_and_usage_of_lms_indicator_id',
        'status',
        'created_by',
        'updated_by',
    ];
    public $timestamps = true; 

    public function facultyMember()
    {
        return $this->belongsTo(User::class, 'faculty_member_id', 'id');
    }
    /**
     * Get the class associated with this course folder.
     */
    public function facultyClass()
    {
        return $this->belongsTo(FacultyMemberClass::class, 'class_cod', 'class_id');
    }
     public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
