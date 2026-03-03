<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchConferenceParticipant extends Model
{
     protected $fillable = [
        'research_conference_impact_id',
        'name',
        'designation',
        'participant_university',
        'participant_country',
        'participated_as',
    ];
}
