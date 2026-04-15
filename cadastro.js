// =============================
// CADASTRO PAGE - JAVASCRIPT
// =============================

// Lista de cadastros em memória
const cadastros = [];

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
  if (!valor.trim()) return 'Informe seu nome completo';
  if (valor.trim().length < 3) return 'O nome deve ter pelo menos 3 caracteres';
  if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(valor.trim())) return 'O nome deve conter apenas letras';
  return '';
}

function validarEmail(valor) {
  if (!valor.trim()) return 'Informe seu email';
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor.trim())) return 'Informe um email válido';
  return '';
}

function validarTelefone(valor) {
  const numeros = valor.replace(/\D/g, '');
  if (!numeros) return 'Informe seu telefone';
  if (numeros.length < 10) return 'Telefone deve ter pelo menos 10 dígitos';
  return '';
}

function validarData(valor) {
  if (!valor) return 'Informe sua data de nascimento';
  const data = new Date(valor);
  const minDate = new Date('2009-01-01');
  if (data < minDate) return 'A data deve ser a partir de 01/01/2009';
  const hoje = new Date();
  if (data > hoje) return 'Data inválida';
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
      '<div class="nome">' + (i + 1) + '. ' + c.nome + '</div>' +
      '<div class="detalhes">' +
        c.email + ' | ' + c.telefone + '<br>' +
        'Nascimento: ' + dataNasc + ' | Gênero: ' + capitalizarPrimeira(c.genero) + '<br>' +
        'Pele: ' + capitalizarPrimeira(peleTxt) + ' | Interesses: ' + interessesTxt + '<br>' +
        '<em>Registrado em ' + c.dataRegistro + '</em>' +
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
