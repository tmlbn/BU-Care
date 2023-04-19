<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MRP_ImmunizationHistory extends Model
{
    use HasFactory;
    protected $table = 'mrp_immunizationhistory';

    protected $primaryKey = 'mrp_immunizationHistoryID';

    public function medicalRecordPersonnel(){
        return $this->belongsTo(MedicalRecordPersonnel::class, 'MRP_id');
    }
    
}
