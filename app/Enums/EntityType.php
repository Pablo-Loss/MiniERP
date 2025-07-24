<?php

namespace App\Enums;

enum EntityType: string {
    case Product = "App\Models\Product";
    case Sku = "App\Models\Sku";
}