function criaEventoAdicionarVariacao(cont = 0) {
    const lista = document.getElementById("lista-skus");
    const botaoAdicionar = document.getElementById("btn-add-sku");

    let skuCount = cont;

    botaoAdicionar.addEventListener("click", function() {
        const div = document.createElement("div");
        div.className = "row align-items-end g-2 mb-2";

        div.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="skus[${skuCount}][name]" placeholder="Nome" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="skus[${skuCount}][price]" placeholder="Preço" step="0.01" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="skus[${skuCount}][currentStock]" placeholder="Estoque" class="form-control" required>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">
                <img src="/images/trash.svg" alt="Remover">
            </button>
        </div>
        `;

        lista.appendChild(div);
        skuCount++;
    });
}

criaEventoAdicionarVariacao(window.skuCount || 0);