<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalInitiative extends Model
{
    protected $fillable = [

        'user_id',

        'title',

        'from_date',
        'to_date',

        'nature_of_initiative',
        'nature_other',

        'scope',

        'description',

        'status',

        'outcome',

        'impact_reach',
        'impact_outcome',

        'sustainability',
        'sustainability_field',

        'strategic_alignment',
        'strategic_goal',

        'supervisor_name',
        'supervisor_designation',
        'supervisor_department',

        'evidence_attachment',

        /*
         * Manager validation
         */
        'manager_decision',
        'manager_remarks',
        'manager_id',
        'submitted_at',
        'manager_decided_at',
    ];

    protected $casts = [
        'from_date'          => 'date',
        'to_date'            => 'date',
        'submitted_at'       => 'datetime',
        'manager_decided_at' => 'datetime',
    ];

    /**
     * Employee who created the initiative
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Manager who approved/rejected the initiative
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}