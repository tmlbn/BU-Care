<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicalRecordPersonnel extends Model
{
    use HasFactory;
    protected $table = 'medicalrecordspersonnel';
    protected $primaryKey = 'MRP_id';
    
    public function MRP_familyHistory(){
        return $this->belongsTo(MRP_FamilyHistory::class, 'MRP_familyHistoryID');
    }
    public function MRP_personalSocialHistory(){
        return $this->belongsTo(MRP_PersonalSocialHistory::class, 'MRP_personalSocialHistoryID');
    }
    public function MRP_immunizationHistory(){
        return $this->belongsTo(MRP_ImmunizationHistory::class, 'MRP_immunizationHistoryID');
    }
    public function MRP_personalMedicalCondition(){
        return $this->belongsTo(MRP_PersonalMedicalCondition::class, 'MRP_personalMedicalConditionID');
    }
    
    public function userPersonnel(){
        return $this->belongsTo(userPersonnel::class, 'personnel_id');
    }
    public function medicalRecordAdmin(){
        return $this->belongsTo(MedicalRecord_Admin::Class, 'MRPA_id');
    }
}
