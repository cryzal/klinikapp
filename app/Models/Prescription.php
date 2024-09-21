<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'medication',
        'fulfilled',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}