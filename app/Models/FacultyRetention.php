<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyRetention extends Model
{

    protected $fillable = [
        'indicator_id',
        'form_status',
        'faculty_id',
        'no_retention_rate',
        'remarks',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
}
