<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalPatientRecord extends Model
{
    use HasFactory;
    protected $table = 'medicalpatientrecords';

    protected $primaryKey = 'MPR_id';

    protected $fillable = [
        'student_id',
        'date',
        'temperature',
        'blood_pressure',
        'weight',
        'height',
        'historyPhysical_examinations',
        'physician_directions',
        'created_at',
        'updated_at'
    ];

    public function MPRstudent(){
        return $this->belongsTo(UserStudent::class, 'student_id');
    }    

}
