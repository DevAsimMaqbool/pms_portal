<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalAssignment extends Model
{
    protected $fillable = [
        'role_id',
        'goal_id',
        'objective_id',
        'dimension_id',
        'kpa_id',
        'dimension_target',
        'dimension_weight',
        'kpi_ids',
        'validate',
        'status'
    ];

    protected $casts = [
        'kpi_ids' => 'array'
    ];
    public function dimension()
    {
        return $this->belongsTo(Dimension::class, 'dimension_id', 'id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    // KPA Relation
    public function kpa()
    {
        return $this->belongsTo(KeyPerformanceArea::class, 'kpa_id', 'id');
    }

}
