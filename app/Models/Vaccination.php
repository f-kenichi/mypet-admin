<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'name',
        'date',
        'vet',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}