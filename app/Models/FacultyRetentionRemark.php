<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyRetentionRemark extends Model
{
    protected $table = 'faculty_retentions_remarks';
        protected $fillable = [
        'faculty_retention_id',
        'faculty_id',
        'no_retention_rate',
        'remarks',
        'status',
    ];
    public function facultyRetention()
    {
        return $this->belongsTo(FacultyRetention::class, 'faculty_retention_id');
    }

}
