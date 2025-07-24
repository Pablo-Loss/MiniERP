<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::all();
        $mensagemSucesso = session('mensagem.sucesso');
        return view('orders.index', compact('orders'))
            ->with('mensagemSucesso', $mensagemSucesso);
    }
}
