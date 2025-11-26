<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyClassAttendance extends Model
{
    protected $fillable = [
        'class_id',
        'faculty_id',
        'program_name',
        'state',
        'att_marked',
        'class_date',
        'total_students',
        'present_count',
        'absent_count',
        'present_percentage',
        'absent_percentage',
        'color',
        'rating',
    ];

    public function facultyClass()
    {
        return $this->belongsTo(FacultyMemberClass::class, 'class_id', 'class_id');
    }
}
