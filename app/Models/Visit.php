<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'clinic',
        'reason',
        'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}