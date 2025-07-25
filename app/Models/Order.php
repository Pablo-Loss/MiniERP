<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'email',
        'cep',
        'coupon',
        'subTotal',
        'frete',
        'total',
        'products',
        'idsProducts',
        'status'
    ];
}
