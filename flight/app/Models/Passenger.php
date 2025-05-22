<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Passenger extends Model
{
    use HasFactory, SoftDeletes;  


    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'dob', 'passport_expiry_date','image'
    ];

    protected $hidden = [
        'password',
    ];
    protected $guarded = ['id'];


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
