<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentIllness extends Model
{
    use HasFactory;
    protected $table = 'presentillness';
    protected $primaryKey = 'presentIllnessID';

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
