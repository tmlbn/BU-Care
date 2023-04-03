<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalSocialHistory extends Model
{
    use HasFactory;
    protected $table = 'personalsocialhistory';
    protected $primaryKey = 'personalSocialHistoryID';

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
