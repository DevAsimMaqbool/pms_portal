<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalAssignmentIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_assignment_detail_id',
        'indicator_id',
    ];
    public function detail()
    {
        return $this->belongsTo(
            GoalAssignmentDetail::class,
            'goal_assignment_detail_id',
            'id'
        );
    }
    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id','id');
    }
}
