<x-layout title="Adicionar cupom">
    <form action="{{ route('coupons.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome do Cupom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Desconto (%)</label>
            <input type="number" class="form-control" id="discount" name="discount" min="1" max="100" required>
        </div>

        <div class="mb-3">
            <label for="valid_until" class="form-label">Validade</label>
            <input type="date" class="form-control" id="valid_until" name="valid_until" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</x-layout>
