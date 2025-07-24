<x-layout title="Adicionar produto">
    @vite([
        'resources/js/products/create.js',
        'resources/js/products/product.js',
        'resources/css/products/product.css'
    ])

    <form action="{{ route('products.store') }}" method="post">
        @csrf
        <div class="row mb-3">
            <div class="col-7">
                <label for="nome" class="form-label">Nome</label>
                <input autofocus type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
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
                    value="{{ old('price') ?? 0.1 }}" 
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
                    class="form-control" 
                    value="{{ old('currentStock') ?? 0 }}" 
                    required
                >
            </div>

            <div class="col-3">
                <label for="productType" class="form-label">Possui variações?</label>
                <select id="productType" name="productType" class="form-select" value="{{ old('productType') }}">
                    <option value="simples">Não (produto simples)</option>
                    <option value="pai">Sim (produto pai)</option>
                </select>
            </div>
        </div>

        <div id="div-skus" class="row mb-3" style="display: none">
            <div class="col-3 mt-2 mb-2">
                <button type="button" id="btn-add-sku" class="btn btn-secondary">Add variação</button>
            </div>
            <div id="lista-skus"></div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</x-layout>