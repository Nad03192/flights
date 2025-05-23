<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function passengers()
    {
        return $this->belongsToMany(Passenger::class)->withTimestamps();
    }
}
