<x-layout title="Lista de Pedidos" :mensagem-sucesso="$mensagemSucesso">

    @if ($orders->isEmpty())
        <p>Nenhum pedido encontrado.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produtos</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>CEP</th>
                        <th>Frete</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                {!! $order->products !!}
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span  
                                    @if ($order->status === 'Pago') class="badge bg-success"
                                    @elseif ($order->status === 'Cancelado') class="badge bg-danger"
                                    @else class="badge bg-secondary" @endif
                                >
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->cep }}</td>
                            <td>R$ {{ number_format($order->frete, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-layout>
