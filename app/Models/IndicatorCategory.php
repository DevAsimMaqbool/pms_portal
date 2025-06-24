<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorCategory extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'key_performance_area_id',
        'indicator_category',
        'created_by',
        'updated_by'
    ];

    public function keyPerformanceArea()
    {
        return $this->belongsTo(KeyPerformanceArea::class, 'key_performance_area_id');
    }
    public function indicators()
    {
        return $this->hasMany(Indicator::class, 'indicator_category_id');
    }
}
