<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'car_id',
        'path',
    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}