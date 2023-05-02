<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MPR_Illness extends Model
{
    use HasFactory;
    protected $table = 'mpr_illness';

    protected $primaryKey = 'MPR_illnessID';

    public function medicalPatientRecord(){
        return $this->belongsTo(MedicalPatientRecord::class, 'MPR_id');
    }
}
