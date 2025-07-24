<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;

interface SkuRepository {
    public function delete(Sku $sku): void;
}