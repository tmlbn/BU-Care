<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPersonnel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users_personnel';

    protected $primaryKey = 'id';

    protected $fillable = [
        'personnel_id_number',
        'email',
        'password',
        'last_name',
        'first_name',
        'middle_name',
        'date_of_birth',
    ];

    protected $guarded = [
        'id',
        'MRP_id',
        'MRPA_id',
        'hasMedRecord',
        'hasValidatedRecord',
        'user_type',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public function medicalRecordPersonnel(){
        return $this->hasOne(MedicalRecordPersonnel::class, 'personnel_id');
    }

    public function medicalRecord_admin(){
        return $this->hasOne(MedicalRecordsPersonnel_Admin::class, 'personnel_id');
    }

    public function medicalPatientRecords(){
        return $this->hasMany(MedicalPatientRecord::class, 'personnel_id');
    }
    
    public function myAppointments(){
        return $this->hasMany(Appointment::class, 'personnel_id');
    }
}
