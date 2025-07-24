<?php

namespace App\Services;

use App\Models\Product;

class ProductService {
    public static function getCartItem($productId) {
        $product = Product::findOrFail($productId);
        if ($product->currentStock < 1) {
            return back()->with('mensagem.erro', 'Produto sem estoque.');
        }

        $item = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'stock' => $product->currentStock,
            'type' => 'product',
        ];
        return $item;
    }
}