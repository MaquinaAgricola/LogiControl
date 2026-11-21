// Confirmação simples antes de excluir registros.
document.querySelectorAll('[data-confirm]').forEach(function (botao) {
  botao.addEventListener('click', function (evento) {
    if (!confirm('Tem certeza que deseja excluir este registro?')) evento.preventDefault();
  });
});

// Adiciona linhas de produtos na tela de geração de frete.
document.addEventListener('click', function (evento) {
  if (evento.target && evento.target.id === 'adicionar-produto') {
    const area = document.getElementById('lista-produtos');
    const modelo = area.querySelector('.linha-produto');
    const nova = modelo.cloneNode(true);
    nova.querySelector('select').value = '';
    area.appendChild(nova);
  }
  if (evento.target && evento.target.classList.contains('remover-produto')) {
    const linhas = document.querySelectorAll('.linha-produto');
    if (linhas.length > 1) evento.target.closest('.linha-produto').remove();
  }
});
