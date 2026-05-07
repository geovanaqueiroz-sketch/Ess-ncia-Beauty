// =============================
// CADASTRO PAGE - JAVASCRIPT
// =============================

// Lista de cadastros em memória
const cadastros = [];

// =============================
// UTILITÁRIO DE SEGURANÇA
// =============================
function escaparHTML(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

// Elementos do DOM
const form = document.getElementById('formCadastro');
const nomeInput = document.getElementById('nomeCompleto');
const emailInput = document.getElementById('emailCadastro');
const telefoneInput = document.getElementById('telefone');
const dataInput = document.getElementById('dataNascimento');
const resultado = document.getElementById('resultadoCadastro');
const listaCadastros = document.getElementById('listaCadastros');
const cadastrosContainer = document.getElementById('cadastrosContainer');
const semCadastros = document.getElementById('semCadastros');

// =============================
// MÁSCARA DE TELEFONE
// =============================
telefoneInput.addEventListener('input', function () {
  let valor = this.value.replace(/\D/g, '');
  if (valor.length > 11) valor = valor.slice(0, 11);

  if (valor.length > 6) {
    this.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 7) + '-' + valor.slice(7);
  } else if (valor.length > 2) {
    this.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
  } else if (valor.length > 0) {
    this.value = '(' + valor;
  }
});

// =============================
// VALIDAÇÃO EM TEMPO REAL
// =============================
nomeInput.addEventListener('input', function () {
  validarCampo(this, 'erroNome', validarNome);
});

emailInput.addEventListener('input', function () {
  validarCampo(this, 'erroEmail', validarEmail);
});

telefoneInput.addEventListener('input', function () {
  validarCampo(this, 'erroTelefone', validarTelefone);
});

dataInput.addEventListener('change', function () {
  validarCampo(this, 'erroData', validarData);
});

// =============================
// FUNÇÕES DE VALIDAÇÃO
// =============================
function validarNome(valor) {
  var nome = valor.trim();
  if (!nome) return 'Informe seu nome completo';
  if (nome.length < 3) return 'O nome deve ter pelo menos 3 caracteres';
  if (nome.length > 100) return 'O nome deve ter no máximo 100 caracteres';
  if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(nome)) return 'O nome deve conter apenas letras';
  if (/\s{2,}/.test(nome)) return 'O nome não deve conter espaços consecutivos';
  var palavras = nome.split(/\s+/);
  if (palavras.length < 2) return 'Informe o nome completo (nome e sobrenome)';
  if (palavras.some(function (p) { return p.length < 2; })) return 'Cada parte do nome deve ter pelo menos 2 letras';
  return '';
}

function validarEmail(valor) {
  var email = valor.trim().toLowerCase();
  if (!email) return 'Informe seu email';
  if (email.length > 254) return 'O email deve ter no máximo 254 caracteres';
  // Stricter regex: no leading/trailing dots, no consecutive dots, TLD >= 2 chars
  var regexEmail = /^[a-zA-Z0-9](?:[a-zA-Z0-9._%+-]*[a-zA-Z0-9])?@[a-zA-Z0-9](?:[a-zA-Z0-9.-]*[a-zA-Z0-9])?\.[a-zA-Z]{2,}$/;
  if (!regexEmail.test(email)) return 'Informe um email válido';
  if (/\.{2,}/.test(email)) return 'O email não pode conter pontos consecutivos';
  // Check for duplicate email in existing registrations
  var duplicado = cadastros.some(function (c) { return c.email.toLowerCase() === email; });
  if (duplicado) return 'Este email já está cadastrado';
  return '';
}

function validarTelefone(valor) {
  var numeros = valor.replace(/\D/g, '');
  if (!numeros) return 'Informe seu telefone';
  if (numeros.length < 10) return 'Telefone deve ter pelo menos 10 dígitos';
  if (numeros.length > 11) return 'Telefone deve ter no máximo 11 dígitos';
  // Validate DDD (Brazilian area code: 11-99, cannot start with 0)
  var ddd = parseInt(numeros.slice(0, 2), 10);
  if (ddd < 11 || ddd > 99) return 'DDD inválido';
  // Reject all-same-digit numbers (e.g., 0000000000)
  if (/^(\d)\1+$/.test(numeros)) return 'Telefone inválido';
  return '';
}

function validarData(valor) {
  if (!valor) return 'Informe sua data de nascimento';
  var data = new Date(valor + 'T00:00:00');
  if (isNaN(data.getTime())) return 'Data de nascimento inválida';
  var minDate = new Date('2009-01-01T00:00:00');
  if (data < minDate) return 'A data deve ser a partir de 01/01/2009';
  var hoje = new Date();
  hoje.setHours(0, 0, 0, 0);
  if (data > hoje) return 'A data de nascimento não pode ser no futuro';
  var idade = hoje.getFullYear() - data.getFullYear();
  var mesAniversario = data.getMonth();
  var diaAniversario = data.getDate();
  if (hoje.getMonth() < mesAniversario ||
      (hoje.getMonth() === mesAniversario && hoje.getDate() < diaAniversario)) {
    idade--;
  }
  if (idade > 120) return 'Data inválida';
  return '';
}

function validarCampo(input, erroId, funcaoValidar) {
  const erro = funcaoValidar(input.value);
  const erroSpan = document.getElementById(erroId);
  if (erro) {
    input.classList.add('erro');
    input.classList.remove('sucesso');
    erroSpan.textContent = erro;
    return false;
  } else {
    input.classList.remove('erro');
    input.classList.add('sucesso');
    erroSpan.textContent = '';
    return true;
  }
}

// =============================
// SUBMIT DO FORMULÁRIO
// =============================
form.addEventListener('submit', function (e) {
  e.preventDefault();

  // Validar todos os campos
  const nomeOk = validarCampo(nomeInput, 'erroNome', validarNome);
  const emailOk = validarCampo(emailInput, 'erroEmail', validarEmail);
  const telOk = validarCampo(telefoneInput, 'erroTelefone', validarTelefone);
  const dataOk = validarCampo(dataInput, 'erroData', validarData);

  if (!nomeOk || !emailOk || !telOk || !dataOk) {
    mostrarResultado('Preencha todos os campos corretamente!', 'erro');
    return;
  }

  // Coletar dados
  const genero = document.querySelector('input[name="genero"]:checked');
  const tipoPele = document.getElementById('tipoPele').value;
  const interesses = [];
  document.querySelectorAll('input[name="interesses"]:checked').forEach(function (cb) {
    interesses.push(cb.value);
  });
  const termos = document.getElementById('termos').checked;

  const cadastro = {
    nome: nomeInput.value.trim(),
    email: emailInput.value.trim(),
    telefone: telefoneInput.value.trim(),
    dataNascimento: dataInput.value,
    genero: genero ? genero.value : '',
    tipoPele: tipoPele,
    interesses: interesses,
    receberOfertas: termos,
    dataRegistro: new Date().toLocaleString('pt-BR')
  };

  cadastros.push(cadastro);
  mostrarResultado('Cadastro realizado com sucesso! Bem-vindo(a), ' + cadastro.nome + '!', 'sucesso');
  atualizarLista();
  form.reset();
  limparEstilosCampos();
});

// =============================
// EXIBIR RESULTADO
// =============================
function mostrarResultado(mensagem, tipo) {
  resultado.textContent = mensagem;
  resultado.className = 'resultado-cadastro ' + tipo;

  setTimeout(function () {
    resultado.textContent = '';
    resultado.className = 'resultado-cadastro';
  }, 5000);
}

// =============================
// LIMPAR ESTILOS DOS CAMPOS
// =============================
function limparEstilosCampos() {
  var inputs = form.querySelectorAll('input, select');
  inputs.forEach(function (input) {
    input.classList.remove('erro', 'sucesso');
  });
  var erros = form.querySelectorAll('.erro-campo');
  erros.forEach(function (span) {
    span.textContent = '';
  });
}

// =============================
// ATUALIZAR LISTA DE CADASTROS
// =============================
function atualizarLista() {
  listaCadastros.classList.add('visivel');

  if (cadastros.length === 0) {
    semCadastros.style.display = 'block';
    cadastrosContainer.innerHTML = '';
    return;
  }

  semCadastros.style.display = 'none';
  cadastrosContainer.innerHTML = '';

  cadastros.forEach(function (c, i) {
    var item = document.createElement('div');
    item.className = 'cadastro-item';

    var interessesTxt = c.interesses.length > 0 ? c.interesses.join(', ') : 'Nenhum';
    var peleTxt = c.tipoPele || 'Não informado';
    var dataNasc = c.dataNascimento ? formatarData(c.dataNascimento) : '';

    item.innerHTML =
      '<div class="nome">' + (i + 1) + '. ' + escaparHTML(c.nome) + '</div>' +
      '<div class="detalhes">' +
        escaparHTML(c.email) + ' | ' + escaparHTML(c.telefone) + '<br>' +
        'Nascimento: ' + escaparHTML(dataNasc) + ' | Gênero: ' + escaparHTML(capitalizarPrimeira(c.genero)) + '<br>' +
        'Pele: ' + escaparHTML(capitalizarPrimeira(peleTxt)) + ' | Interesses: ' + escaparHTML(interessesTxt) + '<br>' +
        '<em>Registrado em ' + escaparHTML(c.dataRegistro) + '</em>' +
      '</div>';

    cadastrosContainer.appendChild(item);
  });
}

// =============================
// UTILITÁRIOS
// =============================
function formatarData(dataStr) {
  var partes = dataStr.split('-');
  return partes[2] + '/' + partes[1] + '/' + partes[0];
}

function capitalizarPrimeira(str) {
  if (!str) return '';
  return str.charAt(0).toUpperCase() + str.slice(1);
}
