<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchTaskAssignedHodDeanTask extends Model
{
    protected $table = 'research_task_assigned_hod_dean_tasks';
    protected $fillable = [
        'research_task_assigned_hod_dean_id',
        'task',
        'linemanager_rating'
    ];

    public function review()
    {
        return $this->belongsTo(ResearchTaskAssignedHodDean::class, 'research_task_assigned_hod_dean_id');
    }
}
