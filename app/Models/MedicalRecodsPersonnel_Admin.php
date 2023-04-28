<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordsPersonnel_Admin extends Model
{
    use HasFactory;
    protected $table = 'medicalrecordspersonnel_admin';
    protected $primaryKey = 'MRPA_id';

    public function medicalRecordsPersonnelAdmin(){
        return $this->belongsTo(MedicalRecordPersonnel::class, 'MRP_id');
    }
}
