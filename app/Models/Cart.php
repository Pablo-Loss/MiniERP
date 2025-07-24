<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public float $subTotal = 0;

    public float $frete = 0;

    public float $discount = 0;

    public float $total = 0;

    public array $items = [];
}
