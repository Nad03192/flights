<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable; 
class Passenger extends Model
{
    use HasFactory, SoftDeletes;
    use Auditable;
    protected $hidden = [
        'password',
    ];
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
    public function flights()
    {
        return $this->belongsToMany(Flight::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'passenger_role');
    }
}
