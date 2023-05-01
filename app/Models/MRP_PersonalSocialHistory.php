<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MRP_PersonalSocialHistory extends Model
{
    use HasFactory;
    protected $table = 'mrp_personalsocialhistory';
    protected $primaryKey = 'MRP_personalSocialHistoryID';

    public function medicalRecordPersonnel(){
        return $this->belongsTo(MedicalRecord::class, 'MRP_id');
    }
}
