export class ApiService {
  constructor(apiBase) {
    this.apiBase = apiBase;
  }

  async fetchVagas(termo = "", tipo = "", experiencia = "", isInitial = false) {
    const bodyArgs = isInitial
      ? { cidade: "Montenegro", estado: "RS" }
      : { termo, cidade: "Montenegro", estado: "RS", tipo, experiencia };
    try {
      const response = await fetch(
        `${this.apiBase}/index.php?action=buscarVagas`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(bodyArgs),
        }
      );
      if (!response.ok) throw new Error("API Error");
      return await response.json();
    } catch (error) {
      console.error("Erro na API:", error);
      throw error;
    }
  }

  async askAI(pergunta) {
    try {
      const response = await fetch(
        `${this.apiBase}/index.php?action=perguntarIA`,
        {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ pergunta }),
        }
      );
      if (!response.ok) throw new Error("API Error");
      return await response.json();
    } catch (error) {
      console.error("Erro na IA:", error);
      throw error;
    }
  }

}
