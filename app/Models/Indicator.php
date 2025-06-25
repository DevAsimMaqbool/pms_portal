<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_category_id',
        'indicator',
        'created_by',
        'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(IndicatorCategory::class, 'indicator_category_id');
    }

}
