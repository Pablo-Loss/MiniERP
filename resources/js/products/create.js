document.addEventListener("DOMContentLoaded", function () {
    criaToggleSkus();
})

function criaToggleSkus() {
    const select = document.getElementById("productType");
    const divSkus = document.getElementById("div-skus");
    const listaSkus = document.getElementById("lista-skus");
    const inputStock = document.getElementById("currentStock");

    function toggleSkus() {
        if (select.value === "pai") {
            divSkus.style.display = "block";
            inputStock.readOnly = true;
            inputStock.value = 0;
            inputStock.classList.add("disabled");
        } else {
            listaSkus.innerHTML = "";
            divSkus.style.display = "none";
            inputStock.readOnly = false;
            inputStock.classList.remove("disabled");
        }
    }

    select.addEventListener("change", toggleSkus);
    toggleSkus();
}

