<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PrescriptionMedicine;
use App\Models\PrescriptionTest;
use App\Models\Medicine;
use App\Models\Test;

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
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }


    public function prescriptionMedicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescriptions_medicine', 'prescription_id')
            ->withPivot('advice', 'note', 'timeOfDay', 'whenTake', 'quantityPerDay', 'duration')
            ->withTimestamps();
    }


    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescriptions_medicine')
            ->withTimestamps();
    }

    public function selectedMedicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescriptions_medicine', 'prescription_id')
            ->withPivot('advice', 'note', 'timeOfDay', 'whenTake', 'quantityPerDay', 'duration')
            ->withTimestamps();
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'prescriptions_test')
            ->withTimestamps();
    }
    public function selectedTests()
    {
        return $this->belongsToMany(Test::class, 'prescriptions_test', 'prescription_id')
            ->withTimestamps();
    }

    public function prescriptionTests()
    {
        return $this->belongsToMany(Test::class, 'prescriptions_test', 'prescription_id')
            ->withTimestamps();
    }


}