<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $primaryKey = 'id';

    public function usersStudent(){
        return $this->belongsTo(UserStudent::class, 'student_id');
    }
    public function usersPersonnel(){
        return $this->belongsTo(UserPersonnel::class, 'personnel_id');
    }
}
