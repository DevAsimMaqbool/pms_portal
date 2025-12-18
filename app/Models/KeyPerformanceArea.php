<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyPerformanceArea extends Model
{
    use HasFactory;
    protected $fillable = ['performance_area','icon','short_code','slug','small_description', 'created_by', 'updated_by'];

    public function indicatorCategories()
    {
        return $this->hasMany(IndicatorCategory::class, 'key_performance_area_id');
    }
}
