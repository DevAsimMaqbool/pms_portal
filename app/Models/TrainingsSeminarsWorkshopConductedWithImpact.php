<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingsSeminarsWorkshopConductedWithImpact extends Model
{
      use HasFactory;

    protected $table = 'trainings_seminars_workshop_conducted_with_impact';

    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'form_status',
        'ket_target',
        'target_of_ken_knowledge_products',
        'event_proposal_forms_submission',
        'no_of_knowledge_products_produced',
        'no_of_participants',
        'no_of_participants_from_the_industry',
        'no_of_participants_from_the_public_sector',
        'status',
        'created_by',
        'updated_by',
    ];
}
