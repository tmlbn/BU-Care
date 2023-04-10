<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserStudent extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users_students';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'applicant_id_number',
        'last_name',
        'first_name',
        'middle_name',
        'birth_month',
        'birth_date',
        'birth_year'
    ];
    protected $guarded = ['id',
        'student_id_number',
        'created_at',
        'updated_at',
        'MR_id',
        'hasMedRecord',
        'hasValidatedRecord',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function medicalRecord(){
        return $this->hasOne(MedicalRecord::class, 'student_id');
    }

    public function medicalPatientRecords(){
        return $this->hasMany(MedicalPatientRecord::class, 'user_student_id');
    }
}
