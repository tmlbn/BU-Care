<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicalPatientRecord extends Model
{
    use HasFactory;
    protected $table = 'medicalpatientrecords';

    protected $primaryKey = 'MPR_id';

    public function MPRstudent(){
        return $this->belongsTo(UserStudent::class, 'student_id');
    }    

    public function MPRpersonnel(){
        return $this->belongsTo(UserStudent::class, 'personnel_id');
    }

    public function mpr_illness(){
        return $this->hasOne(MPR_Illness::class, 'MPR_illnessID');
    }
}
