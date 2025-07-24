<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;

interface ProductRepository {
    public function save(Request $request): Product;

    public function update(Product $product, Request $request): Product;

    public function remove(Product $product);
}