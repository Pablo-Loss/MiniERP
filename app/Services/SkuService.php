<?php

namespace App\Services;

use App\Models\Sku;

class SkuService {
    public static function getCartItem($skuId) {
        $sku = Sku::findOrFail($skuId);
        if ($sku->currentStock < 1) {
            return back()->with('mensagem.erro', 'Variação sem estoque.');
        }

        $item = [
            'sku_id' => $sku->id,
            'product_id' => $sku->productParentId,
            'name' => $sku->name,
            'price' => $sku->price,
            'quantity' => 1,
            'stock' => $sku->currentStock,
            'type' => 'sku',
        ];
        return $item;
    }
}