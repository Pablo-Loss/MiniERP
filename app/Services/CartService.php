<?php

namespace App\Services;

use App\Models\Sku;

class CartService
{
    public static function calculaFrete(float $subTotal): float {
        if ($subTotal > 52 && $subTotal < 166.59) {
            return 15;
        } else if ($subTotal > 200) {
            return 0;
        } else {
            return 20;
        }
    }
}