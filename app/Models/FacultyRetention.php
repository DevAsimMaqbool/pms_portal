<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyRetention extends Model
{

    protected $fillable = [
        'indicator_id',
        'form_status',
        'year',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
    public function remarks()
    {
        return $this->hasMany(FacultyRetentionRemark::class, 'faculty_retention_id');
    }
}
