<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord_Admin extends Model
{
    use HasFactory;
    protected $table = 'medicalrecords_admin';

    protected $primaryKey = 'MRA_id';

    protected $fillable = [
        'bp_systolic',
        'bp_diastolic',
        'pulseRate',
        'respirationRate',
        'temp',
        'height',
        'weight',
        'bmi',
        'xrayFindings',
        'hepaBscreening',
        'bloodType',
        'PE_genAppearance',
        'PE_genAppearanceComment',
        'PE_HEENT',
        'PE_HEENTcomment',
        'PE_chestLungs',
        'PE_chestLungsComment',
        'PE_cardio',
        'PE_cardioComment',
        'PE_abdomen',
        'PE_abdomenComment',
        'PE_genito',
        'PE_genitoComment',
        'PE_musculoskeletal',
        'PE_musculoskeletalComment',
        'PE_nervousSystem',
        'PE_nervousSystemComment',
        'PE_otherSignificantFindings',
        'fitness',
        'notfitPendingReason',
        'MRA_impression',
        'MRA_dateOfExam',
    ];
    protected $guarded = [
        'MRA_id',
        'MR_id',
        'student_id',
    ];

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class, 'MR_id');
    }

    public function usersStudent(){
        return $this->belongsTo(UserStudent::class, 'student_id');
    }
}
