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
        'last_name',
        'first_name',
        'middle_name',
        'birth_month',
        'birth_date',
        'birth_year',
    ];
    protected $guarded = [
        'id',
        'password',
        'created_at',
        'updated_at',
        'PMR_id',
        'hasMedRecord',
        'hasValidatedRecord',
        'user_type',
    ];

    public function medicalRecord_admin(){
        return $this->hasOne(MedicalRecordAdmin::class, 'personnel_id');
    }
    public function medicalPatientRecords(){
        return $this->hasMany(MedicalPatientRecord::class, 'user_student_id');
    }
}
