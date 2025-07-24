<x-layout title="Produtos" :mensagem-sucesso="$mensagemSucesso">
    @vite('resources/js/products/index.js')

    <a href="{{ route('products.create') }}" class="btn btn-dark mb-2">Adicionar</a>

    <ul class="list-group">
        @foreach ($products as $product)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('products.edit', $product->id) }}">
                    {{ $product->name }}
                </a>
                <span class="d-flex">
                    
                    {{-- Botão Comprar --}}
                    @if ($product->productType == App\Enums\ProductType::Simples && $product->currentStock > 0)
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-success btn-sm ms-2">Comprar</button>
                        </form>
                    @elseif ($product->productType == App\Enums\ProductType::Pai && $product->skus->sum('currentStock') > 0)
                        <button type="button" class="btn btn-success btn-sm ms-2" onclick='selecionarSku({{ $product->id }})'>
                            Comprar
                        </button>
                    @else
                        <div class="btn btn-danger btn-sm ms-2">
                            Indisponível
                        </div>
                    @endif

                    {{-- Botão Excluir --}}
                    <form class="ms-2" method="post" id="form-product-delete"
                        action="{{ route('products.destroy', $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Remover">X</button>
                    </form>
                </span>
            </li>
        @endforeach
    </ul>

    <!-- Modal de SKUs -->
    <div class="modal fade" id="skuSelectModal" tabindex="-1" aria-labelledby="skuSelectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" name="sku_id" id="sku_id_modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="skuSelectModalLabel">Escolher variação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="skuOptions"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Adicionar ao Carrinho</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</x-layout>