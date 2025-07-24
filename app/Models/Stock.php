<?php

namespace App\Models;

use App\Enums\EntityType;
use App\Enums\MovementType;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'entity_type',
        'quantity',
        'movementType',
        'entity_id'
    ];

    protected $casts = [
        'entity_type' => EntityType::class,
        'movementType' => MovementType::class
    ];

    public function entity(){
        return $this->morphTo();
    }
}
