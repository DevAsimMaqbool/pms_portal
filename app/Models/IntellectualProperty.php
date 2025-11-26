<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntellectualProperty extends Model
{
        use HasFactory;

    protected $fillable = [
        'indicator_id',
        'form_status',
        'no_of_ip_disclosed',
        'name_of_ip_filed',
        'patents_ip_type',
        'other_detail',
        'area_of_application',
        'date_of_filing_registration',
        'supporting_docs_as_attachment',
        'status',
        'created_by',
        'updated_by',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
