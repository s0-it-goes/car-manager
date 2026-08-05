<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'car_id',
        'name',
        'document_type',
        'path',
    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}