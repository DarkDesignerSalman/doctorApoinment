<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;
use App\Models\Medicine;

class PrescriptionMedicine extends Model
{
    use HasFactory;
    protected $table = 'prescriptions_medicine';

    protected $fillable = [
        'prescription_id',
        'medicine_id',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}