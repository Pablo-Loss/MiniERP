<x-layout title="Editar produto '{!! $product->name !!}'">
    <form action="{{ route('products.update', $product->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-7">
                <label for="nome" class="form-label">Nome</label>
                <input autofocus type="text" id="name" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-2">
                <label for="price" class="form-label">Preço</label>
                <input 
                    type="number"
                    id="price" 
                    name="price" 
                    min="0.01"
                    step="0.01"
                    class="form-control" 
                    value="{{ $product->price }}" 
                    required
                >
            </div>

            <div class="col-2">
                <label for="currentStock" class="form-label">Estoque Atual</label>
                <input 
                    type="number"
                    id="currentStock" 
                    name="currentStock" 
                    min="0"
                    step="1"
                    class="{{$product->productType->value == 'pai' ? 'form-control disabled' : 'form-control' }}" 
                    value="{{ $product->currentStock }}" 
                    required
                    {{ $product->productType->value == 'pai' ? 'readonly' : '' }}
                >
            </div>

            <div class="col-3">
                <label for="productType" class="form-label">Possui variações?</label>
                <select id="productType" name="productType" class="form-select" disabled>
                    <option value="simples" {{ $product->productType->value == 'simples' ? 'selected' : '' }}>Não (produto simples)</option>
                    <option value="pai" {{ $product->productType->value == 'pai' ? 'selected' : '' }}>Sim (produto pai)</option>
                </select>
            </div>
        </div>

        @if ($product->productType->value == 'pai')
            <div id="div-skus" class="row mb-3">
                <div class="col-3 mt-2 mb-2">
                    <button type="button" id="btn-add-sku" class="btn btn-secondary">Add variação</button>
                </div>
                <div id="lista-skus">
                    @foreach ($product->skus as $skuCount => $sku)
                        <div class="row align-items-end g-2 mb-2">
                            <input type="hidden" name="skus[{{ $skuCount }}][id]" value="{{ $sku->id }}">
                            <div class="col-md-3">
                                <input type="text" name="skus[{{ $skuCount }}][name]" placeholder="Nome" class="form-control" value="{{ $sku->name }}" required>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="skus[{{ $skuCount }}][price]" placeholder="Preço" step="0.01" class="form-control" value="{{ $sku->price }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="skus[{{ $skuCount }}][currentStock]" placeholder="Estoque" class="form-control" value="{{ $sku->currentStock }}" required>
                            </div>
                            <div class="col-md-3">
                                <button type="button"
                                    class="btn btn-danger btn-remove-sku"
                                    data-url="{{ route('skus.destroy', $sku->id) }}">
                                    <img src="/images/trash.svg" alt="Remover" style="color: white">
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</x-layout>

<script>
    @if ($product->productType->value == 'pai')
        window.skuCount = {{ count($product->skus) }};
    @endif
</script>

@vite([
    'resources/css/products/product.css',
    'resources/js/products/product.js',
    'resources/js/products/edit.js'
])