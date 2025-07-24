<?php

namespace App\Repositories;

use App\Enums\EntityType;
use App\Models\Sku;
use App\Models\Stock;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;

class EloquentSkuRepository implements SkuRepository {
    public function delete(Sku $sku): void {
        DB::transaction(function () use ($sku) {
            $stockService = new StockService();
            $stockService->deleteStock($sku->id, EntityType::Sku->value);
            $sku->delete();
        });
    }
}