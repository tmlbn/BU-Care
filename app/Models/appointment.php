<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;
    protected $table = 'appointmenttry';
    protected $primaryKey = 'id';
    protected $fillable = [
            'appointmentDate',
            'appointmentTime',
            'services',
            'Others',
            'appointmentDescription',
    ];
}
