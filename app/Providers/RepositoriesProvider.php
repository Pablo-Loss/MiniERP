<?php

namespace App\Providers;

use App\Repositories\EloquentOrderRepository;
use App\Repositories\EloquentProductRepository;
use App\Repositories\EloquentSkuRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SkuRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{

    public array $bindings = [
        ProductRepository::class => EloquentProductRepository::class,
        SkuRepository::class => EloquentSkuRepository::class,
        OrderRepository::class => EloquentOrderRepository::class
    ];

}
