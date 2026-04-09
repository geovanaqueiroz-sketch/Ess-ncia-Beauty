
document.addEventListener("DOMContentLoaded", function () {

    console.log("JS funcionando 🔥");

    // =========================
    // BOTÃO COMPRAR (FUNCIONA SEM DB)
    // =========================
    let botoes = document.querySelectorAll(".comprarBtn");

    botoes.forEach(function (botao) {
        botao.addEventListener("click", function () {

            let card = botao.parentElement;
            let nome = card.querySelector("h2").textContent;

            alert(nome + " adicionado ao carrinho!");
        });
    });

    // =========================
    // VER PRODUTOS
    // =========================
    let botaoProdutos = document.getElementById("verProdutos");
    let produtos = document.getElementById("produtos");

    if (botaoProdutos) {
        botaoProdutos.addEventListener("click", function () {

            if (produtos.style.display === "none" || produtos.style.display === "") {
                produtos.style.display = "block";
            } else {
                produtos.style.display = "none";
            }

        });
    }

    // =========================
    // DATA
    // =========================
    let diaBtn = document.getElementById("diaBtn");
    let mesBtn = document.getElementById("mesBtn");
    let dia = document.getElementById("dia");
    let mes = document.getElementById("mes");
    let ano = document.getElementById("ano");

    if (diaBtn) {
        diaBtn.onclick = function () {
            dia.innerText = Math.floor(Math.random() * 31) + 1;
        };
    }

    if (mesBtn) {
        let meses = ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"];
        let i = 0;

        mesBtn.onclick = function () {
            mes.innerText = meses[i];
            i = (i + 1) % meses.length;
        };
    }

    if (ano) {
        ano.onclick = function () {
            ano.value = Math.floor(Math.random() * 35) + 1990;
        };
    }

});


