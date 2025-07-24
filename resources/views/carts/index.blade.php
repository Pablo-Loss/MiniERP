<x-layout title="Carrinho de Compras">
    @vite('resources/js/carts/index.js')

    <ul class="list-group mb-3">
        @forelse ($cart->items as $key => $item)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $item['name'] }} - R$ {{ number_format($item['price'], 2, ',', '.') }} (x{{ $item['quantity'] }})
                <form action="{{ route('cart.remove', $key) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Remover</button>
                </form>
            </li>
        @empty
            <li class="list-group-item">Carrinho vazio</li>
        @endforelse
    </ul>
    @if ($cart->items)
        <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
            @csrf

            <div class="card mb-3" style="max-width: 400px;">
                <div class="card-header bg-light">
                    <strong>Resumo do Pedido</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <strong>R$ {{ number_format($cart->subTotal, 2, ',', '.') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Frete:</span>
                            <strong>R$ {{ number_format($cart->frete, 2, ',', '.') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Desconto:</span>
                            <strong>R$ {{ number_format($cart->discount, 2, ',', '.') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span><strong>Total:</strong></span>
                            <strong id="total-order" class="text-success fs-5">R$ {{ number_format($cart->total, 2, ',', '.') }}</strong>
                        </li>
                    </ul>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control" 
                            placeholder="seu@email.com" 
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input 
                            type="text" 
                            name="cep" 
                            id="cep" 
                            class="form-control" 
                            placeholder="Digite o CEP" 
                            maxlength="9" 
                            required>
                        <small id="cep-feedback" class="form-text"></small>
                    </div>

                    <div class="mb-3">
                        <label for="coupon" class="form-label">Cupom de Desconto</label>
                        <div class="input-group">
                            <input 
                                type="text" 
                                name="coupon" 
                                id="coupon" 
                                class="form-control" 
                                placeholder="Digite o cupom (opcional)">
                            <button type="button" id="apply-coupon" class="btn btn-outline-primary">Aplicar</button>
                        </div>
                        <small id="coupon-feedback" class="form-text text-danger"></small>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Fazer Pedido</button>
                </div>
            </div>
        </form>
    @endif
</x-layout>