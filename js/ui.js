export class UiService {
  constructor() {
    this.container = document.getElementById("vagasContainer");
    this.loading = document.getElementById("loading");
  }

  mostrarLoading(mostrar) {
    if (this.loading) {
      this.loading.style.display = mostrar ? "block" : "none";
    }
  }

  exibirVagas(vagas) {
    if (!vagas || vagas.length === 0) {
      this.container.innerHTML = `
        <div class="vaga-card">
          <h3>Nenhuma vaga encontrada</h3>
          <p>Tente ajustar os termos de busca.</p>
        </div>
      `;
      return;
    }

    this.container.innerHTML = vagas
      .map(
        (vaga) => `
      <div class="vaga-card">
        <h3 class="vaga-titulo">${this.sanitizeHTML(vaga.titulo)}</h3>
        <div class="vaga-empresa">🏢 ${this.sanitizeHTML(vaga.empresa)}</div>
        <div class="vaga-detalhes">
          <span>📍 ${this.sanitizeHTML(vaga.localizacao)}</span>
          <span>💰 ${this.sanitizeHTML(vaga.salario)}</span>
          <span>⏰ ${this.sanitizeHTML(vaga.tipo)}</span>
          <span>🎯 ${this.sanitizeHTML(vaga.experiencia)}</span>
        </div>
        <p class="vaga-descricao">${this.sanitizeHTML(vaga.descricao)}</p>
        <div class="vaga-contato">
          📧 ${this.sanitizeHTML(vaga.contato)} | 📞 ${this.sanitizeHTML(vaga.telefone)}
        </div>
        <small>🕒 ${this.sanitizeHTML(vaga.data_publicacao)}</small>
        ${this.renderLink(vaga.link_direto)}
      </div>
    `
      )
      .join("");
  }

  renderLink(url) {
    if (!url || url === "#" || url.startsWith("mailto:")) return "";
    // Note: window.abrirVaga is bound in main.js
    return `<button class="vaga-link" data-url="${this.sanitizeHTML(url)}" type="button">🔗 Clique para ver vaga</button>`;
  }



  sanitizeHTML(str) {
    if (typeof str !== "string") return str;
    return str.replace(
      /[&<>'"]/g,
      (tag) =>
        ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          "'": "&#39;",
          '"': "&quot;",
        })[tag] || tag
    );
  }
}
