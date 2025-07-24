<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'discount',
        'valid_until'
    ];

    protected $dates = ['valid_until'];
}

