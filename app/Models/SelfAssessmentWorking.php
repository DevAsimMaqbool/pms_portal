<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfAssessmentWorking extends Model
{

    protected $fillable = [
        'term',
        'challenge',
        'working',
        'created_by',
        'updated_by',
    ];
}
