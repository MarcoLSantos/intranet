<div id="painel-documentos">
  <h2>📂 Navegador de Arquivos</h2>

  <label for="pasta-select">Selecione a pasta:</label>
  <select id="pasta-select">
    <option value="" disabled selected>Escolha uma pasta</option>
    <option value="fluxosAcidentesTrabalho">Fluxos de Acidentes</option>
    <option value="organogramas">Organogramas</option>
    <option value="modelosDeDocumentos">Modelos de Documentos</option>
    <!-- você pode adicionar mais aqui -->
  </select>

  <div id="listagem-arquivos" class="arquivos"></div>
</div>
<script>
const pastaSelect = document.getElementById('pasta-select');
const listagem = document.getElementById('listagem-arquivos');

pastaSelect.addEventListener('change', async () => {
  const pasta = pastaSelect.value;
  listagem.innerHTML = '🔄 Carregando arquivos...';

  try {
    const res = await fetch(`/api/file/list?pasta=${pasta}`);
    const arquivos = await res.json();

    if (arquivos.length === 0) {
      listagem.innerHTML = '📭 Nenhum arquivo encontrado nessa pasta.';
      return;
    }

    listagem.innerHTML = arquivos.map(arquivo => {
      const ext = arquivo.extensao || 'file';
      const nome = arquivo.nome;
      const url = `/api/file/?filePath=${encodeURIComponent(arquivo.caminho)}${ext === 'pdf' ? '&onScreen=1' : ''}`;

      return `
        <div class="arquivo">
          <img src="intra/images/${ext}.png" width="30" height="30">
          <a href="${url}" target="_blank">${nome}</a>
        </div>
      `;
    }).join('');
  } catch (err) {
    listagem.innerHTML = '❌ Erro ao carregar arquivos.';
    console.error(err);
  }
});
</script>
