<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['login', 'password'])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable
{
    protected $fillable = [
        'login',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }
}
