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
        'deliverables',
        'target',
        'achieved_target',
        'update_history',
        'status',
        'created_by',
        'updated_by'
    ];
}
