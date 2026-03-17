import { ApiService } from "./api.js";
import { UiService } from "./ui.js";

class VagasApp {
  constructor() {
    const apiBase = window.location.origin + "/api";
    this.api = new ApiService(apiBase);
    this.ui = new UiService();
    this.init();
  }

  async init() {
    this.setupEventListeners();
    this.setupGlobalErrorHandler();
    await this.carregarVagasIniciais();
  }

  setupGlobalErrorHandler() {
    window.addEventListener("error", (event) => {
      console.error("Global Error Caught:", event.error);
      alert(
        "Ops! Ocorreu um erro inesperado na aplicação. Nossa equipe foi notificada."
      );
    });
    window.addEventListener("unhandledrejection", (event) => {
      console.error("Unhandled Promise Rejection:", event.reason);
    });
  }

  setupEventListeners() {
    document
      .getElementById("searchInput")
      ?.addEventListener("keypress", (e) => {
        if (e.key === "Enter") this.buscarVagas();
      });

    document.getElementById("aiQuestion")?.addEventListener("keypress", (e) => {
      if (e.key === "Enter") this.perguntarIA();
    });

    document
      .querySelector(".search-box button")
      ?.addEventListener("click", () => this.buscarVagas());
    document
      .querySelector(".ai-input button")
      ?.addEventListener("click", () => this.perguntarIA());

    // Event delegation for dynamically created links
    document
      .getElementById("vagasContainer")
      ?.addEventListener("click", (e) => {
        const linkBtn = e.target.closest(".vaga-link");
        if (linkBtn) {
          const url = linkBtn.getAttribute("data-url");
          this.abrirVaga(url);
        }
      });
  }

  async carregarVagasIniciais() {
    this.ui.mostrarLoading(true);
    try {
      const vagas = await this.api.fetchVagas("", "", "", true);
      this.ui.exibirVagas(vagas);
    } catch (error) {
      this.ui.exibirVagas(this.api.getMockData());
    } finally {
      this.ui.mostrarLoading(false);
    }
  }

  async buscarVagas() {
    const termo = document.getElementById("searchInput").value;
    const tipo = document.getElementById("tipoVaga").value;
    const experiencia = document.getElementById("experiencia").value;

    this.ui.mostrarLoading(true);
    try {
      const vagas = await this.api.fetchVagas(termo, tipo, experiencia);
      this.ui.exibirVagas(vagas);
    } catch (error) {
      alert("Erro ao buscar vagas. Tentando com dados locais...");
      this.ui.exibirVagas(this.api.getFilteredMock(termo, tipo, experiencia));
    } finally {
      this.ui.mostrarLoading(false);
    }
  }

  async perguntarIA() {
    const input = document.getElementById("aiQuestion");
    const pergunta = input.value.trim();
    if (!pergunta) return;

    this.ui.adicionarMensagem(pergunta, "user");
    input.value = "";

    try {
      const data = await this.api.askAI(pergunta);
      this.ui.adicionarMensagem(data.resposta, "ai");
    } catch (error) {
      this.ui.adicionarMensagem(
        "Desculpe, estou com problemas técnicos no momento. Tente novamente mais tarde.",
        "ai"
      );
    }
  }

  abrirVaga(url) {
    if (url && url !== "#" && url !== "" && url.startsWith("http")) {
      window.open(url, "_blank", "noopener,noreferrer");
    } else {
      console.warn("URL inválida ou insegura:", url);
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  window.vagasApp = new VagasApp();
});
