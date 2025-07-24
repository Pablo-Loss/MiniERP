<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        $mensagemSucesso = session('mensagem.sucesso');
        return view('coupons.index', compact('coupons'))
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:coupons,name',
            'discount' => 'required|numeric|min:1|max:100',
            'valid_until' => 'required|date|after_or_equal:today',
        ]);

        Coupon::create($validated);

        return redirect()->route('coupons.index')->with('mensagem.sucesso', 'Cupom criado com sucesso!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')->with('mensagem.sucesso', 'Cupom removido com sucesso!');
    }
}

