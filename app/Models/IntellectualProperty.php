<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntellectualProperty extends Model
{
        use HasFactory;

    protected $fillable = [
        'kpa_id',
        'sp_category_id',
        'indicator_id',
        'form_status',
        'no_of_ip_disclosed',
        'no_of_ip_filed',
        'name_of_ip_filed',
        'target_of_ip_disclosures',
        'target_of_ip_filed',
        'status',
        'created_by',
        'updated_by',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
