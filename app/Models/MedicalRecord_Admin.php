<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord_Admin extends Model
{
    use HasFactory;
    protected $table = 'medicalRecord_admin';

    protected $primaryKey = 'MRP_id';

    public function medicalRecord(){
        return $this->belongsTo(MedicalRecord::class, 'MR_id');
    }
}
