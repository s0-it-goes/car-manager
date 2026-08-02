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


    protected static function booted()
    {
        static::updated(function ($client) {

            // Если клиент изменился только из-за touch от Car,
            // эти поля будут пустые
            $changed = $client->getChanges();


            if (
                isset($changed['full_name']) ||
                isset($changed['phone']) ||
                isset($changed['notes']) ||
                isset($changed['dealer_id'])
            ) {
                $client->dealer?->touch();
            }

        });


        static::created(function ($client) {

            $client->dealer?->touch();

        });
    }


    public function cars()
    {
        return $this->hasMany(Car::class);
    }


    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
}