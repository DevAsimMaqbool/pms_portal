<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramProfitability extends Model
{
    protected $fillable = [
        'indicator_id',
        'faculty_id',
        'department_id',
        'program_id',
        'program_level',
        'profitability',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
