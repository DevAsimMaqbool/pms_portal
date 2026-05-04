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
        'reject_status',
        'reject_status_remarks',
        'created_by',
        'updated_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
