<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkReserve extends Model
{
    protected $fillable = [
        'from','to','user_id','park_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function park()
    {
        return $this->belongsTo('App\Park', 'park_id');
    }
}
