<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
    ];

    public function cars(){
        return $this->hasMany(Car::class);
    }
}