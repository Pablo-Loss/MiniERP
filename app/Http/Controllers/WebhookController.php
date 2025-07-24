<?php

namespace App\Http\Controllers;

use App\Enums\MovementType;
use App\Models\Product;
use App\Models\Sku;
use App\Services\StockService;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:Aprovado,Pago,Cancelado',
        ]);

        $order = Order::find($validated['id']);

        if ($validated['status'] === 'Cancelado') {
            DB::transaction(function () use ($order) {
                $stockService = new StockService();
                $idsProducts = json_decode($order->idsProducts, true);
                foreach ($idsProducts as $key => $qty) {
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
                    $entityModel->currentStock += $qty;
                    $entityModel->save();
                    $stockService->createFor($entityModel, MovementType::Entrada, $qty); // entrada de estorno
                }
                $order->delete();
            });
            return response()->json(['message' => 'Pedido cancelado e removido.']);
        }

        $order->update(['status' => $validated['status']]);
        return response()->json(['message' => 'Status do pedido atualizado.']);
    }
}
