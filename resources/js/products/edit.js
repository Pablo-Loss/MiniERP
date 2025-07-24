import Swal from 'sweetalert2';

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.btn-remove-sku').forEach(button => {
        button.addEventListener('click', function () {
            const url = this.dataset.url;
            const row = this.closest('.row');

            Swal.fire({
                title: 'Tem certeza?',
                text: "Essa variação será removida!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, remover!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            row.remove();
                            Swal.fire('Removido!', 'A variação foi excluída.', 'success');
                        } else {
                            Swal.fire('Erro', 'Não foi possível remover.', 'error');
                        }
                    });
                }
            });
        });
    });
});