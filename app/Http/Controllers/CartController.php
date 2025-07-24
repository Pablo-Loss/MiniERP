<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\CartService;
use App\Services\ProductService;
use App\Services\SkuService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{

    public function __construct(private OrderRepository $repository) {}

    public function index()
    {
        $cart = session()->get('cart', new Cart());
        return view('carts.index', compact('cart'));
    }

    public function add(Request $request)
    {
        if ($request->has('sku_id')) {
            $cartKey = 'sku_' . $request->sku_id;
            $item = SkuService::getCartItem($request->sku_id);
        } else if ($request->has('product_id')) {
            $cartKey = 'product_' . $request->product_id;
            $item = ProductService::getCartItem($request->product_id);
        } else {
            return back()->with('mensagem.erro', 'Nenhum produto selecionado.');
        }

        $cart = session()->get('cart', new Cart());

        if (isset($cart->items[$cartKey])) {
            if ($cart->items[$cartKey]['quantity'] < $item['stock']) {
                $cart->items[$cartKey]['quantity']++;
            } else {
                return back()->with('mensagem.erro', 'Estoque insuficiente.');
            }
        } else {
            $cart->items[$cartKey] = $item;
        }
        $cart->subTotal += $item["price"];
        $cart->frete = CartService::calculaFrete($cart->subTotal);
        $cart->total = $cart->subTotal + $cart->frete;

        session()->put('cart', $cart);

        return back()->with('mensagem.sucesso', 'Produto adicionado ao carrinho.');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', new Cart());

        if (array_key_exists($key, $cart->items)) {
            unset($cart->items[$key]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('mensagem.sucesso', 'Item removido do carrinho.');
    }

    public function checkout(Request $request)
    {   
        $cart = session()->get('cart', new Cart());

        $order = new Order();
        $order->email = $request->email;
        $order->cep = $request->cep;
        $order->coupon = $request->coupon;
        $order->subTotal = $cart->subTotal;
        $order->frete = $cart->frete;
        $order->total = $cart->total;
        $order->products = "";

        $productsQty = [];
        foreach ($cart->items as $key => $item) {
            $resumoProduct = "{$item['name']} - R$ {$item['price']} (x{$item['quantity']})<br>";
            $order->products .= $resumoProduct;

            $productsQty[$key] = $item['quantity']; 
        }
        $order->idsProducts = json_encode($productsQty);

        $this->repository->save($order, $productsQty);
        Mail::to($order->email)->send(new OrderConfirmationMail($order));

        session()->forget('cart');
        return to_route('orders.index')->with('mensagem.sucesso', 'Compra finalizada com sucesso!');
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('name', $request->coupon)->first();

        if (!$coupon || Carbon::now()->gt($coupon->valid_until)) {
            return response()->json(['error' => 'Cupom inválido ou expirado.'], 422);
        }

        $cart = session()->get('cart', new Cart());

        $discount = ($coupon->discount / 100) * $cart->subTotal;
        $cart->discount = $discount;
        $cart->total = max($cart->subTotal + $cart->frete - $discount, 0);

        session()->put('cart', $cart);

        return response()->json([
            'discount' => number_format($discount, 2, ',', '.'),
            'total' => number_format($cart->total, 2, ',', '.'),
            'success' => true,
        ]);
    }

}
