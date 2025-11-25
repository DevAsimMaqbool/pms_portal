<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyTarget extends Model
{
     use HasFactory;

    protected $fillable = [
        'indicator_id',
        'user_id',
        'target',
        'form_status',
        'scopus_q1',
        'scopus_q2',
        'scopus_q3',
        'scopus_q4',
        'hec_w',
        'hec_x',
        'hec_y',
        'medical_recognized',
        'national',
        'international',
        'created_by',
        'updated_by'
    ];
     // ✅ Relation: FacultyTarget belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Relation: FacultyTarget belongs to an Indicator
    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
    public function assign()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
