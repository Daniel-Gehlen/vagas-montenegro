export class ApiService {
  constructor(apiBase) {
    this.apiBase = apiBase;
  }

  // Dados mockados para fallback quando API não está disponível (GitHub Pages)
  getMockData() {
    return {
      bne: [
        {
          titulo: 'Auxiliar de Montagem',
          empresa: 'Confidencial',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 1.618 - R$ 7.000',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Vaga para auxiliar de montagem em linha de produção. Experiência desejável em montagem de equipamentos.',
          contato: 'rh@empresa.com',
          telefone: '(51) 3632-1000',
          data_publicacao: new Date(Date.now() - 6 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.bne.com.br/vagas',
          fonte: 'BNE',
          categoria: 'producao'
        },
        {
          titulo: 'Auxiliar de Manutenção',
          empresa: 'Confidencial',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 1.618 - R$ 7.000',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Auxiliar de manutenção industrial. Conhecimento em manutenção preventiva e corretiva.',
          contato: 'rh@industria.com',
          telefone: '(51) 3632-2000',
          data_publicacao: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.bne.com.br/vagas',
          fonte: 'BNE',
          categoria: 'manutencao'
        },
        {
          titulo: 'Auxiliar de farmácia',
          empresa: 'Agrogen Desenvolvimento Genetico S.A.',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 1.000 - R$ 10.000',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Auxiliar de farmácia com conhecimento em produtos veterinários e agrícolas.',
          contato: 'rh@agrogen.com',
          telefone: '(51) 3632-3000',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.bne.com.br/vagas',
          fonte: 'BNE',
          categoria: 'saude'
        },
        {
          titulo: 'Analista de materiais',
          empresa: 'Industria de grande porte',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 1.000 - R$ 15.000',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Análise e controle de materiais para produção. Experiência em almoxarifado e controle de estoque.',
          contato: 'rh@industria.com',
          telefone: '(51) 3632-4000',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.bne.com.br/vagas',
          fonte: 'BNE',
          categoria: 'logistica'
        }
      ],
      catho: [
        {
          titulo: 'VIGILANTE INTERMITENTE - MONTENEGRO / RS',
          empresa: 'Security',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 2.001 - R$ 3.000',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Vaga para vigilante intermitente. Curso de vigilante válido e experiência na área.',
          contato: 'rh@security.com',
          telefone: '(51) 3632-5000',
          data_publicacao: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.catho.com.br/vagas',
          fonte: 'Catho',
          categoria: 'seguranca'
        },
        {
          titulo: 'Ajudante de Cozinha - Montenegro/RS',
          empresa: 'Confidencial',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Vaga para ajudante de cozinha em restaurante. Experiência em preparo de alimentos.',
          contato: 'rh@restaurante.com',
          telefone: '(51) 3632-6000',
          data_publicacao: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.catho.com.br/vagas',
          fonte: 'Catho',
          categoria: 'alimentacao'
        },
        {
          titulo: 'Técnico de Manutenção',
          empresa: 'SELPE ESC UNIF',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Manutenção de equipamentos industriais. Experiência em manutenção preventiva e corretiva.',
          contato: 'rh@selpe.com',
          telefone: '(51) 3632-7000',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.catho.com.br/vagas',
          fonte: 'Catho',
          categoria: 'manutencao'
        }
      ],
      infojobs: [
        {
          titulo: 'Coordenador de Estoque',
          empresa: 'Lojas Quero-Quero',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Coordenação de estoque e logística. Experiência em gestão de inventário e controle de materiais.',
          contato: 'rh@queroquero.com',
          telefone: '(51) 3632-8000',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.infojobs.com.br/vagas',
          fonte: 'InfoJobs',
          categoria: 'logistica'
        },
        {
          titulo: 'Promotor',
          empresa: 'Polly Consultoria em Serviços Terceirizados',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'Tempo parcial',
          experiencia: 'Júnior',
          descricao: 'Promoção de vendas em ponto de venda. Experiência em trade marketing.',
          contato: 'rh@polly.com',
          telefone: '(51) 3632-9000',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.infojobs.com.br/vagas',
          fonte: 'InfoJobs',
          categoria: 'marketing'
        },
        {
          titulo: 'Fiscal',
          empresa: 'Asun Supermercados',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Fiscal de caixa e atendimento. Experiência em supermercado.',
          contato: 'rh@asun.com.br',
          telefone: '(51) 3632-1001',
          data_publicacao: new Date(Date.now() - 22 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.infojobs.com.br/vagas',
          fonte: 'InfoJobs',
          categoria: 'varejo'
        }
      ],
      linkedin: [
        {
          titulo: 'Analista de Suporte (Service Desk) - Montenegro RS',
          empresa: 'Vibra',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 3.000 - R$ 6.000',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Analista de suporte técnico para Service Desk. Experiência em atendimento ao usuário e resolução de problemas.',
          contato: 'rh@vibra.com',
          telefone: '(51) 3632-1002',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.linkedin.com/jobs',
          fonte: 'LinkedIn',
          categoria: 'tecnologia'
        },
        {
          titulo: 'Consultor(a) de vendas (montenegro)',
          empresa: 'Facta Pomotora',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Consultor de vendas para produtos financeiros. Experiência em vendas e relacionamento com cliente.',
          contato: 'rh@facta.com',
          telefone: '(51) 3632-1003',
          data_publicacao: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.linkedin.com/jobs',
          fonte: 'LinkedIn',
          categoria: 'vendas'
        },
        {
          titulo: 'Analista de Suprimentos',
          empresa: 'Confidencial',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 3.502 - R$ 6.304',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Análise e gestão de suprimentos. Experiência em cadeia de suprimentos e compras.',
          contato: 'rh@empresa.com',
          telefone: '(51) 3632-1004',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.linkedin.com/jobs',
          fonte: 'LinkedIn',
          categoria: 'logistica'
        }
      ],
      empresas: [
        {
          titulo: 'Pessoa Engenheira de Manufatura PL (Montagem) - Montenegro/RS',
          empresa: 'John Deere',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Vaga para Engenheiro de Manufatura com experiência em processos de montagem industrial. Responsável por otimização de processos produtivos.',
          contato: 'rh@johndeere.com',
          telefone: '(51) 3632-1005',
          data_publicacao: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.deere.com.br/pt/careers/',
          fonte: 'Site Oficial',
          categoria: 'engenharia'
        },
        {
          titulo: 'Analista de Planejamento e Controle da Manutenção em Montenegro / RS',
          empresa: 'ARAUCO Brasil',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 5.000',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Planejamento e controle de manutenção industrial. Experiência em PCM.',
          contato: 'rh@arauco.com',
          telefone: '(51) 3632-1006',
          data_publicacao: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.arauco.com/br/carreiras/',
          fonte: 'Site Oficial',
          categoria: 'manutencao'
        },
        {
          titulo: 'Auxiliar de Produção',
          empresa: 'TANAC',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Auxiliar de produção industrial. Trabalho em linha de produção.',
          contato: 'rh@tanac.com.br',
          telefone: '(51) 3632-1007',
          data_publicacao: new Date(Date.now() - 16 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.tanac.com.br/trabalhe-conosco/',
          fonte: 'Site Oficial',
          categoria: 'industrial'
        },
        {
          titulo: 'Operador de Máquina em Montenegro - RS',
          empresa: 'RH Mattos',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Operação de máquinas industriais. Experiência em linha de produção.',
          contato: 'rh@rhmattos.com',
          telefone: '(51) 3632-1008',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.rhmattos.com.br/vagas',
          fonte: 'Site Oficial',
          categoria: 'industrial'
        },
        {
          titulo: 'Técnico de Segurança do Trabalho',
          empresa: 'BuscarVagas - Empregos Brasil',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 10.000 - R$ 13.333 mensal',
          tipo: 'CLT',
          experiencia: 'Pleno',
          descricao: 'Técnico de segurança do trabalho. Formação técnica em segurança do trabalho.',
          contato: 'rh@buscarvagas.com',
          telefone: '(51) 3632-1009',
          data_publicacao: new Date(Date.now() - 11 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.buscarvagas.com.br',
          fonte: 'BuscarVagas',
          categoria: 'seguranca'
        },
        {
          titulo: 'Estagiário na área de Implantação',
          empresa: 'Syonet',
          localizacao: 'Montenegro, RS',
          salario: 'R$ 1.200',
          tipo: 'Estágio',
          experiencia: 'Júnior',
          descricao: 'Estágio em implantação de sistemas. Cursando superior em TI ou áreas afins.',
          contato: 'rh@syonet.com',
          telefone: '(51) 3632-1010',
          data_publicacao: new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toLocaleDateString('pt-BR'),
          link_direto: 'https://www.syonet.com/carreiras',
          fonte: 'Site Oficial',
          categoria: 'tecnologia'
        },
        {
          titulo: 'Operador de Pedágio',
          empresa: 'CCR VIAsul',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Júnior',
          descricao: 'Operação de cabine de pedágio. Atendimento ao usuário rodoviário.',
          contato: 'rh@viasul.com.br',
          telefone: '(51) 3632-1011',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.ccrviasul.com.br/carreiras',
          fonte: 'Site Oficial',
          categoria: 'servicos'
        },
        {
          titulo: 'Especialista de Contabilidade',
          empresa: 'Vibra',
          localizacao: 'Montenegro, RS',
          salario: 'A combinar',
          tipo: 'CLT',
          experiencia: 'Sênior',
          descricao: 'Contabilidade geral e tributária. Experiência em escrituração fiscal.',
          contato: 'rh@vibra.com',
          telefone: '(51) 3632-1012',
          data_publicacao: new Date().toLocaleDateString('pt-BR'),
          link_direto: 'https://www.vibra.com.br/trabalhe-conosco',
          fonte: 'Site Oficial',
          categoria: 'contabilidade'
        }
      ]
    };
  }

  // Filtrar vagas por termo, tipo e experiência
  filterJobs(jobs, termo, tipo, experiencia) {
    return jobs.filter(job => {
      const matchesTermo = !termo ||
        job.titulo.toLowerCase().includes(termo.toLowerCase()) ||
        job.empresa.toLowerCase().includes(termo.toLowerCase()) ||
        job.descricao.toLowerCase().includes(termo.toLowerCase());

      const matchesTipo = !tipo || job.tipo.toLowerCase() === tipo.toLowerCase();
      const matchesExperiencia = !experiencia || job.experiencia.toLowerCase() === experiencia.toLowerCase();

      return matchesTermo && matchesTipo && matchesExperiencia;
    });
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

      // Verificar se a resposta é JSON válido
      const contentType = response.headers.get("content-type");
      if (!contentType || !contentType.includes("application/json")) {
        throw new Error("API retornou HTML em vez de JSON");
      }

      if (!response.ok) throw new Error("API Error");
      return await response.json();
    } catch (error) {
      console.warn("API não disponível, usando dados mockados:", error.message);

      // Fallback: usar dados mockados quando a API não está disponível (GitHub Pages)
      const mockData = this.getMockData();
      let vagas = [
        ...mockData.bne,
        ...mockData.catho,
        ...mockData.infojobs,
        ...mockData.linkedin,
        ...mockData.empresas
      ];

      // Filtrar por localização se fornecida
      if (bodyArgs.cidade) {
        vagas = vagas.filter(job =>
          job.localizacao.toLowerCase().includes(bodyArgs.cidade.toLowerCase())
        );
      }

      // Aplicar filtros
      vagas = this.filterJobs(vagas, termo, tipo, experiencia);

      // Embaralhar e limitar a 20 resultados
      vagas = vagas.sort(() => Math.random() - 0.5).slice(0, 20);

      return {
        sucesso: true,
        dados: {
          vagas: vagas,
          total: vagas.length,
          pagina: 1,
          limite: 20,
          total_paginas: 1
        }
      };
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

      // Verificar se a resposta é JSON válido
      const contentType = response.headers.get("content-type");
      if (!contentType || !contentType.includes("application/json")) {
        throw new Error("API retornou HTML em vez de JSON");
      }

      if (!response.ok) throw new Error("API Error");
      return await response.json();
    } catch (error) {
      console.warn("API de IA não disponível, usando fallback:", error.message);
      return {
        sucesso: true,
        resposta: 'Funcionalidade de IA em desenvolvimento. Use a busca para encontrar vagas disponíveis.'
      };
    }
  }
}
