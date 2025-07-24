<?php

namespace App\Services;

use App\Enums\EntityType;
use App\Enums\MovementType;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class StockService
{
    public function createFor(Product|Sku $entity, MovementType $movementType, $qty = null): Stock
    {
        $qty = $movementType != MovementType::Balanco ? $qty : $entity->currentStock;
        return Stock::create([
            'entity_id' => $entity->id,
            'entity_type' => get_class($entity),
            'quantity' => $qty,
            'movementType' => $movementType,
        ]);
    }

    public function deleteStock(int $entity_id, string $entity_type) {
        Stock::where('entity_id', $entity_id)
            ->where('entity_type', $entity_type)
            ->delete();
    }
}
