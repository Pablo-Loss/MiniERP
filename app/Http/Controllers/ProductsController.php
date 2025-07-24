<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function __construct(private ProductRepository $repository) {}

    public function index() {
        $products = Product::all();
        $mensagemSucesso = session('mensagem.sucesso');
        return view('products.index', compact('products'))
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        $product = $this->repository->save($request);
        return to_route("products.index")
            ->with("mensagem.sucesso", "Produto \"{$product->name}\" criado com sucesso!");
    }

    public function edit(Product $product) {
        return view('products.edit')->with('product', $product);
    }

    public function update(Product $product, Request $request) {
        $this->repository->update($product, $request);

        return to_route('products.index')
            ->with('mensagem.sucesso', "Produto \"{$product->name}\" alterado com sucesso");
    }

    public function destroy(Product $product) {
        $this->repository->remove($product);

        return to_route("products.index")
            ->with("mensagem.sucesso", "Produto \"{$product->name}\" removido com sucesso!");
    }
}
