<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Prescription;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'prescriptions_medicine', 'medicine_id', 'prescription_id');
    }
}
