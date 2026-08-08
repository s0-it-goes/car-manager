<?php

namespace App\Models;

use App\Enums\CarTaskStatus;
use App\Enums\CarTaskType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarTask extends Model
{
    protected $fillable = [
        'car_id',
        'task',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'task' => CarTaskType::class,
            'status' => CarTaskStatus::class,
        ];
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}