<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyHistory extends Model
{
    use HasFactory;
    protected $table = 'familyhistory';

    protected $primaryKey = 'familyHistoryID';

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
