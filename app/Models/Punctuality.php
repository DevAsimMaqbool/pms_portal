<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punctuality extends Model
{
    protected $fillable = [
        'indicator_id',
        'year',
        'faculty_id',
        'department_id',
        'program_id',
        'program_level',
        'start_date',
        'end_date',
        'remarks',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
     public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    // Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Program
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
