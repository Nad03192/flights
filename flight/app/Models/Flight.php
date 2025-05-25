<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use Auditable;
    use SoftDeletes;

    protected $guarded = [];

    public function passengers()
    {
        return $this->belongsToMany(Passenger::class)->withTimestamps();
    }
}
