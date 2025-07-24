import Swal from 'sweetalert2';

document.addEventListener("DOMContentLoaded", function () {
    const cepInput = document.getElementById("cep");
    const feedback = document.getElementById("cep-feedback");
    const form = document.getElementById("checkout-form");

    cepInput.addEventListener("input", function () {
        feedback.textContent = "";
        feedback.classList.remove("text-danger", "text-success");
    });

    cepInput.addEventListener("blur", function () {
        const cep = cepInput.value.replace(/\D/g, '');

        if (cep.length == 0) {
            feedback.textContent = "";
            feedback.classList.remove("text-danger", "text-success");
            return;
        }
        if (cep.length !== 8) {
            feedback.textContent = "CEP inválido.";
            feedback.classList.add("text-danger");
            feedback.classList.remove("text-success");
            return;
        }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    feedback.textContent = "CEP não encontrado.";
                    feedback.classList.add("text-danger");
                    feedback.classList.remove("text-success");
                } else {
                    let textContent = `${data.localidade}/${data.uf}`;
                    if (data.logradouro) {
                        textContent = `${data.logradouro}, ${data.bairro} - ${data.localidade}/${data.uf}`;
                    }
                    feedback.textContent = textContent;
                    feedback.classList.remove("text-danger");
                    feedback.classList.add("text-success");
                }
            })
            .catch(() => {
                feedback.textContent = "Erro ao consultar o CEP.";
                feedback.classList.add("text-danger");
                feedback.classList.remove("text-success");
            });
    });

    form.addEventListener("submit", function (e) {
        if (feedback.classList.contains("text-danger")) {
            e.preventDefault();
            Swal.fire({
                text: "Por favor, corrija o CEP antes de finalizar o pedido.",
                icon: "error"
            })
        }
    });

    adicionaLogicaCupom()
});

function adicionaLogicaCupom() {
    const applyButton = document.getElementById('apply-coupon');
    const couponInput = document.getElementById('coupon');
    const feedbackCoupon = document.getElementById('coupon-feedback');

    applyButton?.addEventListener('click', () => {
        const coupon = couponInput.value.trim();
        feedbackCoupon.textContent = '';

        if (!coupon) {
            feedbackCoupon.textContent = 'Digite um cupom.';
            return;
        }

        fetch('/cart/apply-coupon', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ coupon })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                feedbackCoupon.textContent = data.error;
                feedbackCoupon.classList.add('text-danger');
            } else {
                feedbackCoupon.textContent = 'Cupom aplicado com sucesso!';
                feedbackCoupon.classList.remove('text-danger');
                feedbackCoupon.classList.add('text-success');

                document.querySelector('.list-group-item:nth-child(3) strong').textContent = `R$ ${data.discount}`;
                document.querySelector('.list-group-item:nth-child(4) strong#total-order').textContent = `R$ ${data.total}`;
            }
        })
        .catch(() => {
            feedbackCoupon.textContent = 'Erro ao validar o cupom.';
        });
    });
}