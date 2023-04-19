<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $table = 'medicalrecords';
    protected $primaryKey = 'MR_id';

    public function familyHistory(){
        return $this->belongsTo(FamilyHistory::class, 'familyHistoryID');
    }
    public function personalSocialHistory(){
        return $this->belongsTo(PersonalSocialHistory::class, 'personalSocialHistoryID');
    }
    public function pastIllness(){
        return $this->belongsTo(PastIllness::class, 'pastIllnessID');
    }
    public function presentIllness(){
        return $this->belongsTo(PresentIllness::class, 'presentIllnessID');
    }
    public function immunizationHistory(){
        return $this->belongsTo(ImmunizationHistory::class, 'immunizationHistoryID');
    }
    
    public function usersStudent(){
        return $this->belongsTo(UserStudent::class, 'student_id');
    }
    public function medicalRecordAdmin(){
        return $this->belongsTo(MedicalRecord_Admin::Class, 'MRA_id');
    }

    /* Move this to another model */
    public function medicalRecordPersonnel(){
        return $this->belongsTo(MedicalForm_Personnel::Class, 'MRP_id');
    }
    public function medicalRecordPersonnelAdmin(){
        return $this->belongsTo(MedicalRecordPersonnel_Admin::Class, 'MRPA_id');
    }
}
