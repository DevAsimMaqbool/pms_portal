<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingOnImpactOfResearchConferencesOrganized extends Model
{
    use HasFactory;

    protected $table = 'rating_on_impact_of_research_conferences_organized';

    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'form_status',
        'conference_target',
        'event_proposal_form_submission',
        'scopus_indexed_confirmation',
        'status',
        'created_by',
        'updated_by',
    ];
}
