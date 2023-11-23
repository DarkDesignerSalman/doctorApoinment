<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;

class DoctorFile extends Model
{
    use HasFactory;
    protected $fillable = ['doctor_id', 'file_id'];
    public function file()
    {
        return $this->belongsTo(File::class,'file_id');
    }
}
