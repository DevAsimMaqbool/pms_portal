<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumberOfKnowledgeProduct extends Model
{
     protected $fillable = [
        'indicator_id',
        'product_type',
        'total_products',
        'form_status',
        'status',
        'update_history',
        'created_by',
        'updated_by'
    ];
}
