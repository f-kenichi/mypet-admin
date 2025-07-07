<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'birth_date',
        'gender',
        'weight',
    ];

    // Vaccinations relationship
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    // Health Records relationship
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
