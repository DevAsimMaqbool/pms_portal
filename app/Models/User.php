<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasRoles, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'employee_id',
        'name',
        'gender',
        'marital',
        'birthday',
        'cnic',
        'emergency_phone',
        'barcode',
        'job_title',
        'work_phone',
        'mobile_phone',
        'work_location',
        'blood_group',
        'email',
        'department',
        'department_id',
        'employee_code',
        'manager_id',
        'manager_name',
        'level',
        'status',
        'password',
    ];
    public $incrementing = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function forms()
    {
        return $this->belongsToMany(Form::class, 'form_user', 'user_id', 'form_id')->withTimestamps();
    }
    public function roleKpaAssignments()
    {
        return $this->hasMany(RoleKpaAssignment::class, 'role_id', 'role_id');
    }
}
