class VagasApp {
  constructor() {
    this.apiBase = window.location.origin + "/api";
    this.carregarVagasIniciais();
  }

  async carregarVagasIniciais() {
    this.mostrarLoading(true);

    try {
      const response = await fetch(
        `${this.apiBase}/index.php?action=buscarVagas`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            cidade: "Montenegro",
            estado: "RS",
          }),
        }
      );

      const vagas = await response.json();
      this.exibirVagas(vagas);
    } catch (error) {
      console.error("Erro ao carregar vagas:", error);
      this.exibirVagas(this.getVagasMock()); // Fallback para dados mock
    } finally {
      this.mostrarLoading(false);
    }
  }

  async buscarVagas() {
    const termo = document.getElementById("searchInput").value;
    const tipo = document.getElementById("tipoVaga").value;
    const experiencia = document.getElementById("experiencia").value;

    this.mostrarLoading(true);

    try {
      const response = await fetch(
        `${this.apiBase}/index.php?action=buscarVagas`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            termo: termo,
            cidade: "Montenegro",
            estado: "RS",
            tipo: tipo,
            experiencia: experiencia,
          }),
        }
      );

      const vagas = await response.json();
      this.exibirVagas(vagas);
    } catch (error) {
      console.error("Erro na busca:", error);
      alert("Erro ao buscar vagas. Tentando com dados de exemplo...");
      this.exibirVagas(this.filtrarVagasMock(termo, tipo, experiencia));
    } finally {
      this.mostrarLoading(false);
    }
  }

  exibirVagas(vagas) {
    const container = document.getElementById("vagasContainer");

    if (!vagas || vagas.length === 0) {
      container.innerHTML = `
            <div class="vaga-card">
                <h3>Nenhuma vaga encontrada</h3>
                <p>Tente ajustar os termos de busca.</p>
            </div>
        `;
      return;
    }

    container.innerHTML = vagas
      .map(
        (vaga) => `
        <div class="vaga-card">
            <h3 class="vaga-titulo">${vaga.titulo}</h3>
            <div class="vaga-empresa">🏢 ${vaga.empresa}</div>
            <div class="vaga-detalhes">
                <span>📍 ${vaga.localizacao}</span>
                <span>💰 ${vaga.salario}</span>
                <span>⏰ ${vaga.tipo}</span>
                <span>🎯 ${vaga.experiencia}</span>
            </div>
            <p class="vaga-descricao">${vaga.descricao}</p>
            <div class="vaga-contato">
                📧 ${vaga.contato} | 📞 ${vaga.telefone}
            </div>
            <small>🕒 ${vaga.data_publicacao}</small>
            ${
              vaga.link_direto &&
              vaga.link_direto !== "#" &&
              !vaga.link_direto.startsWith("mailto:")
                ? `<div class="vaga-link" onclick="abrirVaga('${vaga.link_direto}')">
                    🔗 Clique para ver vaga
                   </div>`
                : ""
            }
        </div>
    `
      )
      .join("");
  }

  async perguntarIA() {
    const input = document.getElementById("aiQuestion");
    const pergunta = input.value.trim();

    if (!pergunta) return;

    this.adicionarMensagem(pergunta, "user");
    input.value = "";

    try {
      const response = await fetch(
        `${this.apiBase}/index.php?action=perguntarIA`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ pergunta: pergunta }),
        }
      );

      const data = await response.json();
      this.adicionarMensagem(data.resposta, "ai");
    } catch (error) {
      console.error("Erro na IA:", error);
      this.adicionarMensagem(
        "Desculpe, estou com problemas técnicos. Tente novamente em alguns instantes.",
        "ai"
      );
    }
  }

  adicionarMensagem(mensagem, tipo) {
    const container = document.getElementById("aiMessages");
    const messageDiv = document.createElement("div");
    messageDiv.className = `message ${
      tipo === "user" ? "user-message" : "ai-response"
    }`;
    messageDiv.textContent = mensagem;
    container.appendChild(messageDiv);
    container.scrollTop = container.scrollHeight;
  }

  mostrarLoading(mostrar) {
    document.getElementById("loading").style.display = mostrar
      ? "block"
      : "none";
  }

  // Dados mock para fallback
  getVagasMock() {
    return [
      {
        titulo: "Assistente Administrativo",
        empresa: "Cooperativa Languiru",
        localizacao: "Montenegro, RS",
        salario: "R$ 1.800 - R$ 2.200",
        tipo: "CLT",
        experiencia: "Júnior",
        descricao:
          "Atendimento ao público, organização de documentos, apoio às atividades administrativas do setor.",
        contato: "rh@languiru.com.br",
        telefone: "(51) 3632-1400",
        data_publicacao: "Publicada há 2 dias",
        link_direto: "https://www.languiru.com.br/trabalhe-conosco",
      },
      {
        titulo: "Vendedor Experiente",
        empresa: "Supermercado Montenegro",
        localizacao: "Centro, Montenegro/RS",
        salario: "R$ 1.500 + comissões",
        tipo: "CLT",
        experiencia: "Pleno",
        descricao:
          "Vendas no varejo, atendimento ao cliente, organização do setor comercial.",
        contato: "vagas@supermercado-montenegro.com.br",
        telefone: "(51) 99999-9999",
        data_publicacao: "Publicada hoje",
        link_direto:
          "https://www.supermercadosmontenegro.com.br/trabalhe-conosco",
      },
      {
        titulo: "Operador de Produção",
        empresa: "Indústria Metalúrgica",
        localizacao: "Distrito Industrial, Montenegro/RS",
        salario: "R$ 2.000 - R$ 2.500",
        tipo: "CLT",
        experiencia: "Júnior",
        descricao:
          "Operação de máquinas, controle de qualidade, atividades na linha de produção industrial.",
        contato: "selecao@industriametalurgica.com",
        telefone: "(51) 3632-2020",
        data_publicacao: "Publicada há 1 semana",
        link_direto: "https://www.industriametalurgica.com.br/carreiras",
      },
    ];
  }

  filtrarVagasMock(termo, tipo, experiencia) {
    let vagas = this.getVagasMock();

    if (termo) {
      vagas = vagas.filter(
        (vaga) =>
          vaga.titulo.toLowerCase().includes(termo.toLowerCase()) ||
          vaga.descricao.toLowerCase().includes(termo.toLowerCase())
      );
    }

    if (tipo) {
      vagas = vagas.filter((vaga) => vaga.tipo === tipo);
    }

    if (experiencia) {
      vagas = vagas.filter((vaga) => vaga.experiencia === experiencia);
    }

    return vagas;
  }
}

// Inicializar app quando a página carregar
document.addEventListener("DOMContentLoaded", () => {
  window.vagasApp = new VagasApp();
});

// Funções globais para os botões HTML
function buscarVagas() {
  window.vagasApp.buscarVagas();
}

function perguntarIA() {
  window.vagasApp.perguntarIA();
}

// Função para abrir links - CORRIGIDA
function abrirVaga(url) {
  console.log("🔗 Tentando abrir URL:", url);

  if (
    url &&
    url !== "#" &&
    url !== "Visite a empresa" &&
    url.startsWith("http")
  ) {
    // Abre em nova aba
    window.open(url, "_blank", "noopener,noreferrer");
  } else if (url && url.includes("@")) {
    // É um email - abre cliente de email
    window.location.href = `mailto:${url}`;
  } else {
    console.warn("URL inválida:", url);
  }
}

// Permitir Enter na busca
document
  .getElementById("searchInput")
  ?.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      buscarVagas();
    }
  });

document
  .getElementById("aiQuestion")
  ?.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      perguntarIA();
    }
  });

// Adicionar CSS para o link clicável
const style = document.createElement("style");
style.textContent = `
  .vaga-link {
    margin-top: 10px;
    color: #667eea;
    font-weight: bold;
    cursor: pointer;
    text-decoration: underline;
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 5px;
    display: inline-block;
  }
  .vaga-link:hover {
    background: #e9ecef;
    color: #5a67d8;
  }
`;
document.head.appendChild(style);
