<x-layout title="Cupons" :mensagem-sucesso="$mensagemSucesso">
    @vite('resources/js/products/index.js')

    <a href="{{ route('coupons.create') }}" class="btn btn-dark mb-3">Adicionar</a>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Desconto</th>
                        <th>Validade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->name }}</td>
                            <td>{{ $coupon->discount }}%</td>
                            <td>{{ \Carbon\Carbon::parse($coupon->valid_until)->format('d/m/Y') }}</td>
                            <td>
                                <form method="post" action="{{ route('coupons.destroy', $coupon->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Remover">X</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum cupom cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
