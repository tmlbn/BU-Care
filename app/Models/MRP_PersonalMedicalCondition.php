<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MRP_PersonalMedicalCondition extends Model
{
    use HasFactory;
    protected $table = 'mrp_personalmedicalcondition';
    protected $primaryKey = 'mrp_personalMedicalConditionID';

    public function medicalRecordPersonnel(){
        return $this->belongsTo(MedicalRecord::class, 'MRP_id');
    }
}
