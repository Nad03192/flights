<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    protected $guarded = [];

    public function passengers()
    {
        return $this->belongsToMany(Passenger::class)->withTimestamps();
    }
}
