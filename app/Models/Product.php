<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'currentStock',
        'productType'
    ];

    protected $casts = [
        'productType' => ProductType::class,
    ];

    public function skus() {
        return $this->hasMany(Sku::class, 'productParentId');
    }

    public function stock(){
        return $this->morphOne(Stock::class, 'entity');
    }
}
