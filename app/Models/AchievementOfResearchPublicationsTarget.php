<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementOfResearchPublicationsTarget extends Model
{

    protected $table = 'achievement_of_research_publications_target';

    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'target_category',
        'target_of_publications',
        'progress_on_publication', // <- add this
        'draft_stage',
        'email_screenshot',
        'scopus_link',
        'status',
        'faculty_member_id',
        'capacity_building',
        'need',
        'any_specifics_related_to_capacity_building',
        'frequency',
        'form_status',
        'created_by',
        'updated_by',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }

}
