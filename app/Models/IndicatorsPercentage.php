<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorsPercentage extends Model
{
    protected $fillable = [
        'employee_id',
        'key_performance_area_id',
        'indicator_category_id',
        'indicator_id',
        'score',
        'rating',
        'color',
    ];
}
