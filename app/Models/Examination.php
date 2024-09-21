<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_name',
        'examination_time',
        'height',
        'weight',
        'systole',
        'diastole',
        'heart_rate',
        'respiration_rate',
        'temperature',
        'notes',
        'file',
        'medication',
        'served',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
