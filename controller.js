document.addEventListener("DOMContentLoaded", function () {

    console.log("Site funcionando 🔥");

    // =========================
    // MENU LATERAL
    // =========================
    let menuBtn = document.getElementById("menuBtn");
    let menu = document.getElementById("menuLateral");

    menuBtn.onclick = function () {
        menu.style.left = (menu.style.left === "0px") ? "-200px" : "0px";
    };

    // =========================
    // CADASTRO
    // =========================
    let form = document.querySelector(".cadastro");
    let msg = document.getElementById("mensagemCadastro");

    form.onsubmit = function (e) {
        e.preventDefault();

        let nome = document.getElementById("nome").value;
        let email = document.getElementById("email").value;

        if (nome === "" || email === "") {
            msg.textContent = "Preencha tudo!";
            msg.style.color = "red";
            return;
        }

        msg.textContent = "Cadastro feito!";
        msg.style.color = "green";

        form.reset();
    };

    // =========================
    // MARCAS POR CATEGORIA
    // =========================
    const marcas = {
        perfumes: [
            { nome: "O Boticário", link: "https://www.boticario.com.br" },
            { nome: "Natura", link: "https://www.natura.com.br" },
            { nome: "Avon", link: "https://www.avon.com.br" }
        ],

        maquiagem: [
            { nome: "MAC", link: "https://www.maccosmetics.com.br" },
            { nome: "Maybelline", link: "https://www.maybelline.com.br" },
            { nome: "Ruby Rose", link: "https://www.rubyrose.com.br" }
        ],

        skincare: [
            { nome: "La Roche-Posay", link: "https://www.laroche-posay.com.br" },
            { nome: "Neutrogena", link: "https://www.neutrogena.com.br" },
            { nome: "Nivea", link: "https://www.nivea.com.br" }
        ]
    };

    // =========================
    // MOSTRAR MARCAS
    // =========================
    function carregarMarcas(categoria) {

        let container = document.getElementById("produtos");
        container.innerHTML = "";

        marcas[categoria].forEach(function (marca) {

            container.innerHTML += `
                <div class="card">
                    <h2>${marca.nome}</h2>
                    <a href="${marca.link}" target="_blank">
                        <button>Ver site</button>
                    </a>
                </div>
            `;
        });
    }

    // =========================
    // BOTÕES DAS ABAS
    // =========================
    let btnPerfume = document.getElementById("btnPerfume");
    let btnMaquiagem = document.getElementById("btnMaquiagem");
    let btnSkincare = document.getElementById("btnSkincare");

    if (btnPerfume) {
        btnPerfume.onclick = () => carregarMarcas("perfumes");
    }

    if (btnMaquiagem) {
        btnMaquiagem.onclick = () => carregarMarcas("maquiagem");
    }

    if (btnSkincare) {
        btnSkincare.onclick = () => carregarMarcas("skincare");
    }

    // =========================
    // DATA (ATIVIDADE)
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