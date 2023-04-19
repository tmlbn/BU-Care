<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalPatientRecord extends Model
{
    use HasFactory;
    protected $table = 'medicalpatientrecords';

    protected $primaryKey = 'MPR_id';

    protected $fillable = [
        'student_id',
        'personnel_id',
        'MPR_illnessID',
        'date',
        'temperature',
        'bloodPressure',
        'weight',
        'height',
        'historyAndPhysicalExamination',
        'physicianDirections',
        'created_at',
        'updated_at'
    ];

    public function MPRstudent(){
        return $this->belongsTo(UserStudent::class, 'student_id');
    }    

    public function MPRpersonnel(){
        return $this->belongsTo(UserStudent::class, 'personnel_id');
    } 
}
