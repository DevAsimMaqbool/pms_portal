<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineManagerFeedback extends Model
{

    protected $fillable = [
        'employee_id',
        'year',
        'responsibility_accountability_1',
        'responsibility_accountability_2',
        'empathy_compassion_1',
        'empathy_compassion_2',
        'humility_service_1',
        'humility_service_2',
        'honesty_integrity_1',
        'honesty_integrity_2',
        'inspirational_leadership_1',
        'inspirational_leadership_2',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
        // Replace FacultyMember::class if your employee model is named differently
    }
}
