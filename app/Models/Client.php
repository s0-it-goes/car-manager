<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'notes',
        'dealer_id'
    ];

    public function cars(){
        return $this->hasMany(Car::class);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
}