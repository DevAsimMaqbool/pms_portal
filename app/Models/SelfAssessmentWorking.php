<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfAssessmentWorking extends Model
{

    protected $fillable = [
        'kpa',
        'term',
        'general_comments',
        'challenge',
        'strength',
        'working',
        'created_by',
        'updated_by',
    ];
}
