<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'weight',
        'temperature',
        'mood',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}