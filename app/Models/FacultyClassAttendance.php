<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyClassAttendance extends Model
{
    protected $fillable = [
        'class_id',
        'class_date',
        'total_students',
        'present_count',
        'absent_count',
        'present_percentage',
        'absent_percentage',
        'color',
        'rating',
    ];
}
