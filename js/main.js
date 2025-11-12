document.addEventListener('DOMContentLoaded', () => {
  inicializarNavegacao();
  inicializarFiltrosCatalogo();
  inicializarFormularioContato();
  inicializarPaginaDeRetorno();
});

function inicializarNavegacao() {
  const botoes = document.querySelectorAll('[data-navigate]');

  if (!botoes.length) return;

  botoes.forEach((botao) => {
    botao.addEventListener('click', () => {
      const destino = botao.getAttribute('data-navigate');

      if (destino) {
        window.location.href = destino;
      }
    });
  });
}

function inicializarFiltrosCatalogo() {
  const abas = document.querySelectorAll('.aba-filtro[data-filtro]');
  const categorias = document.querySelectorAll('.categoria-cartas[data-categoria]');

  if (!abas.length || !categorias.length) return;

  const aplicarFiltro = (filtro) => {
    categorias.forEach((categoria) => {
      const tipo = categoria.getAttribute('data-categoria');
      const deveExibir = filtro === 'todos' || filtro === tipo;

      categoria.style.display = deveExibir ? 'grid' : 'none';
    });
  };

  abas.forEach((aba) => {
    aba.addEventListener('click', () => {
      const filtro = aba.getAttribute('data-filtro');

      abas.forEach((item) => item.classList.remove('active'));
      aba.classList.add('active');
      aplicarFiltro(filtro);
    });
  });

  // aplica filtro inicial
  const abaAtiva = document.querySelector('.aba-filtro.active');
  aplicarFiltro(abaAtiva ? abaAtiva.getAttribute('data-filtro') : 'todos');
}

function inicializarFormularioContato() {
  const formulario = document.getElementById('contactForm');

  if (!formulario) return;

  const botaoReset = document.getElementById('resetBtn');
  const feedback = document.getElementById('formFeedback');

  if (botaoReset) {
    botaoReset.addEventListener('click', () => {
      formulario.reset();

      if (feedback) {
        feedback.textContent = 'Formulário limpo.';
      }
    });
  }
}

function inicializarPaginaDeRetorno() {
  const resultado = document.getElementById('result');
  const statusMsg = document.getElementById('statusMsg');

  if (!resultado || !statusMsg) return;

  const parametros = new URLSearchParams(window.location.search);
  const nome = parametros.get('name') || 'Não informado';
  const email = parametros.get('email') || 'Não informado';
  const telefone = parametros.get('phone') || 'Não informado';
  const assunto = parametros.get('subject') || 'Não informado';
  const mensagem = parametros.get('message') || 'Não informado';

  statusMsg.textContent = 'Mensagem enviada com sucesso!';
  resultado.innerHTML = `
    <p><strong>Nome:</strong> ${nome}</p>
    <p><strong>Email:</strong> ${email}</p>
    <p><strong>Telefone:</strong> ${telefone}</p>
    <p><strong>Assunto:</strong> ${assunto}</p>
    <p><strong>Mensagem:</strong> ${mensagem}</p>
  `;
}

