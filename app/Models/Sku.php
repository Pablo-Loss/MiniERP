<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $fillable = [
        'name',
        'price',
        'currentStock',
        'productParentId'
    ];

    public function product() {
        $this->belongsTo(Product::class);
    }

    public function estoque(){
        return $this->morphOne(Stock::class, 'entity');
    }

}
