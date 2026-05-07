document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // MENU LATERAL
    // =========================
    var menuBtn = document.getElementById("menuBtn");
    var menu = document.getElementById("menuLateral");
    var menuOverlay = document.getElementById("menuOverlay");
    var menuClose = document.getElementById("menuClose");

    function abrirMenu() {
        menu.classList.add("aberto");
        menuOverlay.classList.add("ativo");
    }

    function fecharMenu() {
        menu.classList.remove("aberto");
        menuOverlay.classList.remove("ativo");
    }

    menuBtn.onclick = function () {
        if (menu.classList.contains("aberto")) {
            fecharMenu();
        } else {
            abrirMenu();
        }
    };

    menuClose.onclick = fecharMenu;
    menuOverlay.onclick = fecharMenu;

    // Fechar menu ao clicar nos links
    var links = document.querySelectorAll("#menuLateral a");
    links.forEach(function (link) {
        link.addEventListener("click", fecharMenu);
    });

    // =========================
    // CADASTRO - VALIDAÇÃO
    // =========================
    var form = document.querySelector(".cadastro");
    var msg = document.getElementById("mensagemCadastro");

    if (form && msg) {
        form.onsubmit = function (e) {
            e.preventDefault();

            var nome = document.getElementById("nome").value.trim();
            var email = document.getElementById("email").value.trim();

            if (nome === "" || email === "") {
                msg.textContent = "Preencha todos os campos!";
                msg.style.color = "#e74c3c";
                return;
            }

            msg.textContent = "Cadastro realizado com sucesso!";
            msg.style.color = "#27ae60";

            form.reset();
            var diaEl = document.getElementById("dia");
            var mesEl = document.getElementById("mes");
            if (diaEl) diaEl.innerText = "";
            if (mesEl) mesEl.innerText = "";
        };
    }

    // =========================
    // MARCAS POR CATEGORIA
    // =========================
    var marcas = {
        perfumes: [
            { nome: "O Boticário", link: "https://www.boticario.com.br/perfumes" },
            { nome: "Natura", link: "https://www.natura.com.br/c/perfumaria" },
            { nome: "Avon", link: "https://www.avon.com.br/c/perfumaria" }
        ],

        maquiagem: [
            { nome: "MAC", link: "https://www.maccosmetics.com.br" },
            { nome: "Maybelline", link: "https://www.maybelline.com.br" },
            { nome: "Ruby Rose", link: "https://www.rubyrose.com.br" }
        ],

        skincare: [
            { nome: "La Roche-Posay", link: "https://www.laroche-posay.com.br/vitamina-c" },
            { nome: "Neutrogena", link: "https://www.neutrogena.com.br/cuidado-facial" },
            { nome: "Nivea", link: "https://www.nivea.com.br/produtos/rosto/cuidado" }
        ]
    };

    // =========================
    // MOSTRAR MARCAS (DINÂMICO)
    // =========================
    function carregarMarcas(categoria) {
        var container = document.getElementById("marcasContainer");
        container.innerHTML = "";

        marcas[categoria].forEach(function (marca) {
            var card = document.createElement("div");
            card.className = "marca-card";

            var h3 = document.createElement("h3");
            h3.textContent = marca.nome;
            card.appendChild(h3);

            var link = document.createElement("a");
            link.href = marca.link;
            link.target = "_blank";
            link.rel = "noopener noreferrer";

            var btn = document.createElement("button");
            btn.textContent = "Ver site";
            link.appendChild(btn);
            card.appendChild(link);

            container.appendChild(card);
        });

        // Scroll suave até as marcas
        container.scrollIntoView({ behavior: "smooth", block: "nearest" });
    }

    // =========================
    // BOTÕES DAS CATEGORIAS
    // =========================
    var btnPerfume = document.getElementById("btnPerfume");
    var btnMaquiagem = document.getElementById("btnMaquiagem");
    var btnSkincare = document.getElementById("btnSkincare");

    if (btnPerfume) {
        btnPerfume.onclick = function () { carregarMarcas("perfumes"); };
    }

    if (btnMaquiagem) {
        btnMaquiagem.onclick = function () { carregarMarcas("maquiagem"); };
    }

    if (btnSkincare) {
        btnSkincare.onclick = function () { carregarMarcas("skincare"); };
    }

    // =========================
    // DATA DE NASCIMENTO
    // =========================
    var diaBtn = document.getElementById("diaBtn");
    var mesBtn = document.getElementById("mesBtn");
    var dia = document.getElementById("dia");
    var mes = document.getElementById("mes");
    var ano = document.getElementById("ano");

    // Gerar dia aleatório
    if (diaBtn) {
        diaBtn.onclick = function () {
            dia.innerText = Math.floor(Math.random() * 31) + 1;
        };
    }

    // Alternar meses
    if (mesBtn) {
        var meses = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
        var i = 0;

        mesBtn.onclick = function () {
            mes.innerText = meses[i];
            i = (i + 1) % meses.length;
        };
    }

    // Ano preenchido automaticamente
    if (ano) {
        ano.value = new Date().getFullYear();
        ano.onclick = function () {
            ano.value = Math.floor(Math.random() * 35) + 1990;
        };
    }

});
