<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_id',
        'indicator_name',
        'slug',
        'status',
        'created_by',
        'updated_by',
        'roles',
    ];

    protected $casts = [
        'roles' => 'array',
    ];
     public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id', 'id');
    }
}
