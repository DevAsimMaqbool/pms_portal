<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class FacultyPursuingSkill extends Model
{
    use HasFactory;

    protected $table = 'faculty_pursuing_skills';

    protected $fillable = [
        'indicator_id',
        'cpd_type',
        'cpd_other_detail',
        'evidence_reference',
        'remarks',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
