<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    protected $fillable = [
        'name', 'latitude', 'longitude'
    ];

    public function reserve()
    {
        return $this->hasMany('App\ParkReserve');
    }
}
