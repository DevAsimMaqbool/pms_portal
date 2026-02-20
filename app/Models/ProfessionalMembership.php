<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_id',
        'form_status',
        'type_of_membership',
        'name_of_professional_body',
        'category_of_body',
        'discipline',
        'level',
        'country',
        'membership_status',
        'membership_start_date',
        'membership_valid_until',
        'evidence_type',
        'document_link',
        'declaration',
        'status',
        'update_history',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'evidence_type' => 'array',
        'declaration' => 'boolean',
        'membership_start_date' => 'date',
        'membership_valid_until' => 'date',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
