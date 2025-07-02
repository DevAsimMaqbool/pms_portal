<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleKpaAssignment extends Model
{
    protected $fillable = [
        'role_id',
        'key_performance_area_id',
        'indicator_category_id',
        'indicator_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function keyPerformanceArea()
    {
        return $this->belongsTo(KeyPerformanceArea::class);
    }

    public function category()
    {
        return $this->belongsTo(IndicatorCategory::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }
}
