<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionWiseSurvey extends Model
{
    protected $fillable = [
        'campus_id',
        'faculty_id',
        'program',
        'batch',
        'section',
        'course',
        'component_class',
        'faculty_member',
        'feedback',
        'response_rate',
        'attempts',
        'registered_students'
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
