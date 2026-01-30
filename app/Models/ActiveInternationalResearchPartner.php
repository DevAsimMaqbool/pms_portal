<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ActiveInternationalResearchPartner extends Model
{
    use HasFactory;

    protected $table = 'active_international_research_partners';

     protected $fillable = [
        'indicator_id',
        'form_status',
        'university_name',
        'country',
        'city',
        'signing_authorities',
        'duration_of_agreement',
        'outcome_timeline',
        'collaboration_scope',
        'contact_details',
        'projects_activities_planned',
        'update_history',
        'status',
        'created_by',
        'updated_by'
    ];
}
