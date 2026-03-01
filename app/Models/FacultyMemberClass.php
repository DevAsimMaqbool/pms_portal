<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyMemberClass extends Model
{
    protected $fillable = [
        'class_id',
        'faculty_id',
        'class_name',
        'code',
        'term_id',
        'term',
        'career_id',
        'career',
        'career_code',
        'average_marks',
        'passing_percentage'
    ];

    public function attendances()
    {
        return $this->hasMany(FacultyClassAttendance::class, 'class_id', 'class_id');
    }
}
