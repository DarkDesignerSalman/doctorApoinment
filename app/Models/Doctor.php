<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Department;
use App\Models\Qualification;
use App\Models\User;


class Doctor extends Model
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'birth_date',
        'qualification_id',
        'department_id',
        'join_date',
        'gender',
    ];

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
