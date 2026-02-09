<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoGlobalStreamTarget extends Model
{
     protected $fillable = [
        'indicator_id',
        'programs_offered',
        'total_enrolled_students',
        'target',
        'timeline',
        'registered_students',
        'process_stage',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
