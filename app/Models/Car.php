<?php

namespace App\Models;

use App\Enums\CarStatus;
use App\Enums\Country;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'client_id',
        'country',
        'brand',
        'model',
        'year',
        'chassis_number',
        'buy_price',
        'status',
        'notes',
        'purchased_at',
        'arrived_at',
        'completed_at',
    ];

    protected $casts = [
        'buy_price' => 'decimal:2',
        'purchased_at' => 'datetime',
        'arrived_at' => 'datetime',
        'completed_at' => 'datetime',
        'year' => 'integer',
        'status' => CarStatus::class,
        'country' => Country::class,
    ];

    protected $touches = ['client'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    
    public function tasks()
    {
        return $this->hasMany(CarTask::class);
    }
    
}