<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumberOfKnowledgeProduct extends Model
{
    protected $fillable = [
        'indicator_id',
        'product_type',
        'url',
        'attach_evidence',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
     public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
