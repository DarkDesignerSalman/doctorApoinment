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
    return $this->belongsToMany(Prescription::class, 'prescription_medicine')
        ->withPivot('advice', 'note', 'timeOfDay', 'whenTake', 'quantityPerDay', 'duration');
}
}
