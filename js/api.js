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

  getMockData() {
    return [
      {
        titulo: "Assistente Administrativo",
        empresa: "Cooperativa Languiru",
        localizacao: "Montenegro, RS",
        salario: "R$ 1.800 - R$ 2.200",
        tipo: "CLT",
        experiencia: "Júnior",
        descricao: "Atendimento ao público, organização de documentos...",
        contato: "rh@languiru.com.br",
        telefone: "(51) 3632-1400",
        data_publicacao: "Publicada há 2 dias",
        link_direto: "https://www.languiru.com.br/trabalhe-conosco",
      },
      {
        titulo: "Operador de Produção",
        empresa: "Indústria Metalúrgica",
        localizacao: "Distrito Industrial, Montenegro/RS",
        salario: "R$ 2.000 - R$ 2.500",
        tipo: "CLT",
        experiencia: "Júnior",
        descricao: "Operação de máquinas, controle de qualidade...",
        contato: "selecao@industriametalurgica.com",
        telefone: "(51) 3632-2020",
        data_publicacao: "Publicada há 1 semana",
        link_direto: "https://www.industriametalurgica.com.br/carreiras",
      },
    ];
  }

  getFilteredMock(termo, tipo, experiencia) {
    let vagas = this.getMockData();
    if (termo)
      vagas = vagas.filter((v) =>
        v.titulo.toLowerCase().includes(termo.toLowerCase())
      );
    if (tipo) vagas = vagas.filter((v) => v.tipo === tipo);
    if (experiencia) vagas = vagas.filter((v) => v.experiencia === experiencia);
    return vagas;
  }
}
