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

class UserClinic extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users_clinic';

    protected $primaryKey = 'id';

    public function accomplishedPersonnelMedicalRecord(){
        return $this->hasMany(MedicalRecordsPersonnel_Admin::class, 'doctor_id');
    }
    public function accomplishedStudentMedicalRecord(){
        return $this->hasMany(edicalRecordsPersonnel::class, 'doctor_id');
    }
}
