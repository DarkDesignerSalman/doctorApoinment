<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PrescriptionMedicine;
use App\Models\Medicine;

class Prescription extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'date',
    ];

   public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescriptionMedicine()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescriptions_medicine')
            ->withTimestamps();
    }

    public function selectedMedicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescriptions_medicine', 'prescription_id')->withPivot('advice', 'note', 'timeOfDay', 'whenTake', 'quantityPerDay', 'duration')
            ->withTimestamps();
    }
}