<?php

namespace App\Repositories;

use App\Enums\MovementType;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;

class EloquentOrderRepository implements OrderRepository {
    public function save(Order $order, array $productsQty): void {
        DB::transaction(function () use ($order, $productsQty) {
            $order->save();
            $stockService = new StockService();
            foreach ($productsQty as $key => $qty) {
                $aKey = explode('_', $key);
                $typeEntity = $aKey[0];
                $idEntity = $aKey[1];

                if ($typeEntity == 'product') {
                    $entityModel = new Product();
                    $entityModel = Product::find($idEntity);
                } else {
                    $entityModel = new Sku();
                    $entityModel = Sku::find($idEntity);
                }
                $entityModel->currentStock -= $qty;
                $entityModel->save();
                $stockService->createFor($entityModel, MovementType::Saida, $qty);
            }
        });
    }
}