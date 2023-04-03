<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImmunizationHistory extends Model
{
    use HasFactory;
    protected $table = 'immunizationhistory';

    protected $primaryKey = 'immunizationHistoryID';

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
