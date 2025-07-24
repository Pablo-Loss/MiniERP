import Swal from 'sweetalert2';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

const form = document.querySelector('#form-product-delete');
form.addEventListener('submit', event => {
    event.preventDefault();
    Swal.fire({
        text: "Tem certeza que deseja excluir o produto?",
        icon: "warning",
        confirmButtonText: "Excluir",
        confirmButtonColor: "red",
        showCancelButton: true,
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

window.selecionarSku = (productId) => {
    fetch(`/products/${productId}/skus`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('skuOptions');
            container.innerHTML = '';
            data.forEach(sku => {
                if (sku.currentStock > 0) {
                    const radio = document.createElement('div');
                    radio.className = 'form-check';
                    radio.innerHTML = `
                        <input class="form-check-input" type="radio" name="sku_id" value="${sku.id}" id="sku-${sku.id}" required>
                        <label class="form-check-label" for="sku-${sku.id}">
                            ${sku.name} - R$ ${sku.price}
                        </label>
                    `;
                    container.appendChild(radio);
                }
            });
            const modal = new bootstrap.Modal(document.getElementById('skuSelectModal'));
            modal.show();
        });
}