<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number',
        'departure_city',
        'arrival_city',
        'departure_time',
        'arrival_time',
        'available_seats',
    ];

    public function passengers()
    {
        return $this->belongsToMany(Passenger::class)->withTimestamps();
    }
}
