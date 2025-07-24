# MINI ERP

Aplicação criada para gerenciar produtos (e suas variações), estoque, pedidos e cupons.

As tecnologias utilizadas foram: Laravel, PHP, JavaScript, Bootstrap e MySQL.

## Observações:
- Foi utilizada a arquitetura MVC
- A ORM escolhida foi Eloquent, porém criei os prodviders prevendo caso um dia seja queira alterar a ORM (Doctrine, PDO e etc.)
- Para as lógicas de banco de dados foram criados arquivos de Repository, seguindo a boa prática. Também foram utilizadas as transações (transactions) para garantir a integridade dos dados.
- As tabelas foram criadas com associações.
- Para adicionar todas tabelas é só executar php artisan migrate.
- O carrinho de compras é gerenciado em sessão.
- Caso o subtotal do pedido tenha entre R$52,00 e R$166,59, o frete do pedido será de R$15,00. Caso o subtotal seja maior que R$200,00, frete grátis. Para outros valores, o frete custará R$20,00.
- O campo de CEP possui validação pela API do ViaCEP
- Ao concluir um pedido um e-mail é enviado ao e-mail cadastrado (porém as configurações de MAIL no arquivo .env devem ser configuradas para o envio)
- Foi criado um webhook para alterar o status dos pedidos.
    - URL: {URL}/api/webhook/order-status
    - Body: {"id": 7, "status": "Cancelado"}
    - Headers: Content-Type: application/json

# APLICAÇÃO NA PRÁTICA
Fiz alguns vídeos pra explicar o funcionamento da aplicação!

### Produtos: [link do vídeo](https://drive.google.com/file/d/1TNPB2F9MAnaBok0MRysWTZ8zSF_qFxl_/view?usp=drive_link)

### Cupons: [link do vídeo](https://drive.google.com/file/d/19chZtlDmR50ZPGu2mi5IialqvIZy-YLn/view?usp=drive_link)

### Pedidos: [link do vídeo](https://drive.google.com/file/d/1AGEmibFGjGWl6GpAwuAwE6aXoGQoYF8K/view?usp=drive_link)

### Pedidos e Estoque: [link do vídeo](https://drive.google.com/file/d/1_1EexPUkBP2T5-z4l6LvkqsDwmE1zWBv/view?usp=drive_link)

### Webhook: [link do vídeo](https://drive.google.com/file/d/17klTgs1858spAbu-03UsOjH4rWmW7cre/view?usp=drive_link)
