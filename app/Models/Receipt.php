<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'medicine_id',
        'qty',
        'dosage',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    
}