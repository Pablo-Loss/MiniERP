<?php

namespace App\Repositories;

use App\Models\Order;

interface OrderRepository {
    public function save(Order $order, array $productsQty): void;
}