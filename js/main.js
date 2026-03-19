import { ApiService } from "./api.js";
import { UiService } from "./ui.js";

class VagasApp {
  constructor() {
    // Detect environment and set API base URL accordingly
    const isProduction = window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1';
    const apiBase = isProduction
      ? `${window.location.origin}/api`  // Use same domain in production
      : "http://localhost:8080/api";     // Use localhost in development
    this.api = new ApiService(apiBase);
    this.ui = new UiService();
    this.init();
  }

  async init() {
    this.setupThemeToggle();
    this.setupEventListeners();
    this.setupGlobalErrorHandler();
    await this.carregarVagasIniciais();
  }

  setupThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
      themeToggle.textContent = '☀️';
    }

    themeToggle.addEventListener('click', () => {
      const currentTheme = document.documentElement.getAttribute('data-theme');
      if (currentTheme === 'dark') {
        document.documentElement.removeAttribute('data-theme');
        localStorage.removeItem('theme');
        themeToggle.textContent = '🌙';
      } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        themeToggle.textContent = '☀️';
      }
    });
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

    document
      .getElementById("btnBuscar")
      ?.addEventListener("click", () => this.buscarVagas());

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
      const response = await this.api.fetchVagas("", "", "", true);
      const vagas = response?.dados?.vagas || response?.vagas || [];
      this.ui.exibirVagas(vagas);
    } catch (error) {
      console.warn(
        "Aviso: Nenhuma vaga carregada inicialmente ou erro na API."
      );
    } finally {
      this.ui.mostrarLoading(false);
    }
  }

  async buscarVagas() {
    const termo = document.getElementById("searchInput").value.trim();
    const tipo = document.getElementById("tipoVaga").value;
    const experiencia = document.getElementById("experiencia").value;

    // Validação de entrada
    if (termo.length < 2 && termo !== '') {
      alert("Digite pelo menos 2 caracteres para buscar.");
      return;
    }

    this.ui.mostrarLoading(true);
    try {
      const response = await this.api.fetchVagas(termo, tipo, experiencia);
      const vagas = response?.dados?.vagas || response?.vagas || [];
      this.ui.exibirVagas(vagas);
    } catch (error) {
      alert("Não foi possível realizar a busca no momento. Tente novamente mais tarde.");
      console.error("Erro na busca:", error);
    } finally {
      this.ui.mostrarLoading(false);
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
