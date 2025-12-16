<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfNomination extends Model
{
    protected $fillable = [
        'employee_id',
        'sitara_qiyadat_awards',
        'sitara_qiyadat_why',
        'fakhr_karkardagi_awards',
        'fakhr_karkardagi_why',
        'tamgha_tahqeeq_awards',
        'tamgha_tahqeeq_why',
        'chaudhry_akram_awards',
        'chaudhry_akram_why',
        'service_superheroes_awards',
        'service_superheroes_why',
        'disclaimer',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'sitara_qiyadat_awards' => 'array',
        'fakhr_karkardagi_awards' => 'array',
        'tamgha_tahqeeq_awards' => 'array',
        'chaudhry_akram_awards' => 'array',
        'service_superheroes_awards' => 'array',
        'disclaimer' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }
}
