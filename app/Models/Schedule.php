<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\Qualification;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'qualification_id',
        'date',
        'start_time',
        'end_time',

    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }
}
