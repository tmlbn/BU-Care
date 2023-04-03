<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PastIllness extends Model
{
    use HasFactory;
    protected $table = 'pastillness';
    protected $primaryKey = 'pastIllnessID';

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
