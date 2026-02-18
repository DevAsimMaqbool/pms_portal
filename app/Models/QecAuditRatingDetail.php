<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QecAuditRatingDetail extends Model
{
    protected $fillable = [
        'qec_audit_rating_id',
        'audit_term',
        'faculty_id',
        'department_id',
        'program_id',
        'program_level',
        'total_score',
        'obtained_score',
        'strenght',
        'area_of_improvement'
    ];

    public function audit()
    {
        return $this->belongsTo(QecAuditRating::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
