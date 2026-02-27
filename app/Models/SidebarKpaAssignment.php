<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SidebarKpaAssignment extends Model
{
    protected $fillable = [
        'role_id',
        'user_id',
        'key_performance_area_id',
        'kpa_weightage',
        'indicator_category_id',
        'indicator_category_weightage',
        'indicator_id',
        'indicator_weightage',
        'form_status',
        'status'
    ];
    public function kpa()
    {
        return $this->belongsTo(KeyPerformanceArea::class, 'key_performance_area_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(IndicatorCategory::class, 'indicator_category_id', 'id');
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id', 'id');
    }
     public function role()
    {
        return $this->belongsTo(Role::class, 'role_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
