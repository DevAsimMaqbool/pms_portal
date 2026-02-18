<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QecAuditRating extends Model
{
    protected $fillable = [
        'indicator_id',
        'user_id',
        'form_status',
        'status',
        'remarks',
        'update_history',
        'created_by',
        'updated_by'
    ];

    public function details()
    {
        return $this->hasMany(QecAuditRatingDetail::class, 'qec_audit_rating_id');
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
