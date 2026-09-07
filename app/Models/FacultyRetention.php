<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyRetention extends Model
{

    protected $fillable = [
        'indicator_id',
        'form_status',
        'year',
        'year_id',
        'term_id',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];
    public function remarks()
    {
        return $this->hasMany(FacultyRetentionRemark::class, 'faculty_retention_id');
    }
     public function year()
    {
        return $this->belongsTo(Years::class, 'year_id', 'id');
    }
}
