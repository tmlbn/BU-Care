<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MRP_FamilyHistory extends Model
{
    use HasFactory;
    protected $table = 'mrp_familyhistory';

    protected $primaryKey = 'mrp_familyHistoryID';

    public function medicalRecordPersonnel(){
        return $this->belongsTo(MedicalRecordPersonnel::class, 'MRP_id');
    }
}
