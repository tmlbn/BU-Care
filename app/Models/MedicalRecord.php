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

    protected $fillable = [
        'campus',
        'course',
        'SYstart',
        'SYend',
        'age',
        'sex',
        'placeOfBirth',
        'civilStatus',
        'homeAddress',
        'nationality',
        'religion',
        'fatherName',
        'fatherOccupation',
        'fatherOfficeAddress',
        'motherName',
        'motherOccupation',
        'motherOfficeAddress',
        'guardianName',
        'guardianAddress',
        'parentGuardianContactNumber',
        'studentContactNumber',
        'hospitalization',
        'hospDetails',
        'takingMedsRegularly',
        'medsDetails',
        'allergic',
        'allergyDetails',
        'chestXray',
        'CBCResults',
        'hepaBscreening',
        'bloodType',
        'studentSignature',
        'parentGuardianSignature',
    ];
    protected $guarded = [
        'student_id',
        'familyHistoryID',
        'personalSocialHistoryID',
        'pastIllnessID',
        'presentIllnessID',
        'immunizationHistoryID',
        'MRP_id',
        'MFP',
        'MFP_id',
        
    ];

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
        return $this->belongsTo(MedicalRecord_Admin::Class, 'MRP_id');
    }
    public function medicalFormPersonnel(){
        return $this->belongsTo(MedicalForm_Personnel::Class, 'MFP');
    }
    public function medicalRecordPersonnelAdmin(){
        return $this->belongsTo(MedicalRecordPersonnel_Admin::Class, 'MFP_id');
    }
}
 