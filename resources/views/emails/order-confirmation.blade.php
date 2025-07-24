<h2>Olá,</h2>
<p>Seu pedido foi realizado com sucesso!</p>

<p><strong>Resumo do pedido:</strong></p>
<ul>
    <li><strong>CEP:</strong> {{ $order->cep }}</li>
    <li><strong>Frete:</strong> R$ {{ number_format($order->frete, 2, ',', '.') }}</li>
    <li><strong>Total:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</li>
</ul>

<p><strong>Produtos:</strong><br>
    {!! $order->products !!}
</p>

<p>Obrigado por comprar conosco!</p>
