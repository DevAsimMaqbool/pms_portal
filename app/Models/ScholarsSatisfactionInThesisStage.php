<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarsSatisfactionInThesisStage extends Model
{
    protected $fillable = [
        'indicator_id',
        'empathy_and_compassion',
        'inspirational_leadership',
        'honesty_and_integrity',
        'responsibility_and_accountability',
        'humility_and_service_at_institutional_level',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
