<?php

namespace App\Repositories;

use App\Enums\EntityType;
use App\Enums\MovementType;
use App\Enums\ProductType;
use App\Models\Product;
use App\Models\Sku;
use App\Repositories\ProductRepository;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentProductRepository implements ProductRepository 
{
    public function save(Request $request): Product 
    {
        return DB::transaction(function () use ($request)
        {
            $product = Product::create($request->all());
            $stockService = new StockService();
            $possuiVariacoes = isset($request->skus);

            if ($possuiVariacoes) {
                $skus = $request->skus;
                foreach ($skus as $sku) {
                    $sku['productParentId'] = $product->id;
                    $skuModel = Sku::create($sku);
                    $stockService->createFor($skuModel, MovementType::Balanco);
                }
            } else {
                $stockService->createFor($product, MovementType::Balanco);
            }

            return $product;
        });
    }

    public function update(Product $product, Request $request): Product 
    {
        return DB::transaction(function () use ($request, $product)
        {
            $stockService = new StockService();
            $product->fill($request->all());

            if ($product->productType->value == 'pai' && isset($request->skus)) {
                $skus = $request->skus;
                foreach ($skus as $key => $sku) {
                    $sku['productParentId'] = $product->id;
                    if (isset($sku['id'])) {
                        $skuModel = new Sku();
                        $skuModel = Sku::find($sku['id']);
                        $skuModel->fill($sku)->save();
                        $stockService->createFor($skuModel, MovementType::Balanco);
                    } else {
                        $skuModel = Sku::create($sku);
                        $stockService->createFor($skuModel, MovementType::Balanco);
                    }
                }
            } else if ($product->productType->value == 'simples') {
                $stockService->createFor($product, MovementType::Balanco);
            }

            $product->save();
            return $product;
        });
    }

    public function remove(Product $product) {
        DB::transaction(function () use ($product)
        {
            $stockService = new StockService();
            if ($product->productType == ProductType::Pai) {
                foreach ($product->skus as $sku) {
                    $stockService->deleteStock($sku->id, EntityType::Sku->value);
                }
            }
            $stockService->deleteStock($product->id, EntityType::Product->value);
            $product->delete();
        });
    }
}