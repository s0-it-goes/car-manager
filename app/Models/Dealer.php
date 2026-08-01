<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = [
        'full_name',
        'notes',
    ];


    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}