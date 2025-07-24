<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Repositories\SkuRepository;

class SkuController extends Controller
{

    public function __construct(private SkuRepository $repository) {}

    public function destroy(Sku $sku) {
        $this->repository->delete($sku);

        return response()->noContent();
    }
}
