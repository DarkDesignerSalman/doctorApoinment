<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;
use App\Models\Test;

class PrescriptionTest extends Model
{
    use HasFactory;
    protected $table = 'prescriptions_test';

    protected $fillable = [
        'prescription_id',
        'test_id',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'prescriptions_test', 'prescription_id', 'test_id');
    }
}