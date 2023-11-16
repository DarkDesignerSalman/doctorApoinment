<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;

class DoctorDetail extends Model
{
    use HasFactory;
        protected $fillable = [
        'doctor_id',
        'doctor_name',
        'qualification',
        'department',
        'days_of_week',
        'branch',
        'image',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
