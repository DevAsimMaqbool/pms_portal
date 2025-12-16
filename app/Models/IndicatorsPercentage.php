<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'badge_name',
        'given_by',
    ];

    public function kpa()
    {
        return $this->belongsTo(KeyPerformanceArea::class, 'key_performance_area_id');
    }

    public function category()
    {
        return $this->belongsTo(IndicatorCategory::class, 'indicator_category_id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }
}
