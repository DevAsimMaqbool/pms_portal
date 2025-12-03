<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoAchievementOfMultidisciplinaryProjectsTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_id',
        'project_name',
        'other_disciplines',
        'partner_industry',
        'identified_public_sector_entity',
        'completion_time_of_project',
        'product_developed',
        'third_party_validation',
        'ip_claim',
        'provide_details',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
    protected $casts = [
        'update_history' => 'array',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
