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
        'icon',
        'short_code',
        'slug', 
        'small_description',
        'created_by',
        'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(IndicatorCategory::class, 'indicator_category_id');
    }
    public function indicatorForm()
    {
        return $this->hasMany(IndicatorForm::class, 'indicator_id', 'id');
    }

}
