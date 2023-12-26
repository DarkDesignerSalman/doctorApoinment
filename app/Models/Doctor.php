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
use App\Models\DoctorFile;


class Doctor extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
        'image'

    ];

    public function profilePicture()
    {

        return $this->hasOne(DoctorFile::class)->orderBy('id', 'asc');
    }
    public function attachment()
    {
        return $this->hasMany(DoctorFile::class);
    }
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