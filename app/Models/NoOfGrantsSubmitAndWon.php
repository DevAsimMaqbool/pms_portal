<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoOfGrantsSubmitAndWon extends Model
{
    use HasFactory;

    protected $table = 'no_of_grants_submit_and_wons';
    protected $fillable = [
        'indicator_id',
        'name',
        'funding_agency',
        'volume',
        'role',
        'grant_status',
        'proof',
        'form_status',
        'status',
        'created_by',
        'updated_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
