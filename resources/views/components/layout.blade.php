<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Mini ERP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
        <div class="container">
            <a href="{{ route('products.index') }}" class="navbar-brand">
                <strong>Início</strong>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('coupons.index') }}">Cupons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Pedidos</a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                    🛒 Carrinho
                    @php
                        $cart = session('cart', new \App\Models\Cart());
                        $totalItens = array_sum(array_column($cart->items, 'quantity'));
                    @endphp
                    @if ($totalItens > 0)
                        <span class="position-absolute top-0 start-100 badge rounded-pill bg-danger" style="transform: translate(-110%, -35%);">
                            {{ $totalItens }}
                        </span>
                    @endif
                </a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h1>{{ $title }}</h1>

        @isset($mensagemSucesso)
            <div class="alert alert-success">
                {{ $mensagemSucesso }}
            </div>
        @endisset

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        {{ $slot }}
    </div>
</body>
</html>