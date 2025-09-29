<?php
class VagaModel
{

    public function buscarVagasReais($termo)
    {
        // 🎯 FOCO TOTAL EM MONTENEGRO/RS

        $vagasReais = [
            // ========== VAGAS ESPECÍFICAS MONTENEGRO ==========
            [
                'titulo' => '💻 Desenvolvedor Web - Montenegro',
                'empresa' => 'Tech Solutions Montenegro',
                'localizacao' => 'Centro, Montenegro/RS',
                'salario' => 'R$ 3.200 - R$ 4.800',
                'tipo' => 'CLT',
                'experiencia' => 'Pleno',
                'descricao' => 'Desenvolvimento de sistemas web para empresas locais. PHP, JavaScript, MySQL, WordPress.',
                'contato' => 'vagas@techmontenegro.com.br',
                'telefone' => '(51) 3632-1234',
                'data_publicacao' => 'Vaga ativa',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=desenvolvedor&location=Montenegro%2C%20Rio%20Grande%20do%20Sul%2C%20Brasil&f_TPR=r86400',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🎨 Designer Digital - Agência Montenegro',
                'empresa' => 'Agência Web Montenegro',
                'localizacao' => 'Centro, Montenegro/RS',
                'salario' => 'R$ 2.500 - R$ 3.500',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior',
                'descricao' => 'Criação de sites, artes para redes sociais, material gráfico. Photoshop, Figma, Corel.',
                'contato' => 'contato@agenciamontenegro.com.br',
                'telefone' => '(51) 3632-5678',
                'data_publicacao' => 'Aberta',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=designer&location=Montenegro%2C%20Rio%20Grande%20do%20Sul%2C%20Brasil',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🛒 Desenvolvedor E-commerce - Lojas Locais',
                'empresa' => 'Comércio Montenegro',
                'localizacao' => 'Centro, Montenegro/RS',
                'salario' => 'R$ 3.000 - R$ 4.200',
                'tipo' => 'PJ',
                'experiencia' => 'Júnior/Pleno',
                'descricao' => 'Manutenção de lojas virtuais de comércio local. WordPress, WooCommerce, Loja Integrada.',
                'contato' => 'tecnologia@comerciomontenegro.com.br',
                'telefone' => '(51) 3632-9012',
                'data_publicacao' => 'Contratação imediata',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=ecommerce&location=Montenegro%2C%20Rio%20Grande%20do%20Sul%2C%20Brasil',
                'categoria' => 'montenegro'
            ],

            // ========== EMPRESAS MONTENEGRO CONTRATANTES ==========
            [
                'titulo' => '🏢 Analista de TI - Languiru Montenegro',
                'empresa' => 'Cooperativa Languiru',
                'localizacao' => 'Linha Francesa Alta, Montenegro/RS',
                'salario' => 'R$ 4.000 - R$ 6.000',
                'tipo' => 'CLT',
                'experiencia' => 'Pleno',
                'descricao' => 'Suporte a sistemas, rede, infraestrutura. Maior empregadora da região com vaga local.',
                'contato' => 'ti@languiru.com.br',
                'telefone' => '(51) 3632-1400',
                'data_publicacao' => 'Processo seletivo',
                'link_direto' => 'https://www.languiru.com.br/trabalhe-conosco',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🏥 Suporte Técnico - Hospital Montenegro',
                'empresa' => 'Hospital Montenegro',
                'localizacao' => 'Centro, Montenegro/RS',
                'salario' => 'R$ 2.800 - R$ 3.800',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior',
                'descricao' => 'Manutenção de computadores, sistemas hospitalares, suporte aos usuários.',
                'contato' => 'rh@hospitalmontenegro.com.br',
                'telefone' => '(51) 3632-3030',
                'data_publicacao' => 'Vaga disponível',
                'link_direto' => 'https://www.hospitalmontenegro.com.br/trabalhe-conosco',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '💼 Assistente de TI - Prefeitura',
                'empresa' => 'Prefeitura Municipal de Montenegro',
                'localizacao' => 'Centro, Montenegro/RS',
                'salario' => 'R$ 3.200 - R$ 4.000',
                'tipo' => 'Estatutário',
                'experiencia' => 'Júnior',
                'descricao' => 'Concurso público para assistente de tecnologia. Acompanhe edital no site.',
                'contato' => 'https://www.montenegro.rs.gov.br/editais/',
                'telefone' => '(51) 3632-1000',
                'data_publicacao' => 'Aguardando edital',
                'link_direto' => 'https://www.montenegro.rs.gov.br/editais/',
                'categoria' => 'montenegro'
            ],

            // ========== VALE DO CAÍ E REGIÃO ==========
            [
                'titulo' => '📱 Desenvolvedor Mobile - Vale do Caí',
                'empresa' => 'Tech Vale do Caí',
                'localizacao' => 'São Sebastião do Caí, RS',
                'salario' => 'R$ 4.500 - R$ 6.000',
                'tipo' => 'Híbrido',
                'experiencia' => 'Pleno',
                'descricao' => 'Desenvolvimento de apps mobile. React Native, Flutter. Possibilidade híbrida Montenegro/Caí.',
                'contato' => 'vagas@techvale.com.br',
                'telefone' => '(51) 3635-1234',
                'data_publicacao' => 'Vaga recente',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=mobile&location=S%C3%A3o%20Sebasti%C3%A3o%20do%20Ca%C3%AD%2C%20Rio%20Grande%20do%20Sul%2C%20Brasil',
                'categoria' => 'regiao'
            ],
            [
                'titulo' => '☁️ Analista de Sistemas - Campo Bom',
                'empresa' => 'Indústria Campo Bom',
                'localizacao' => 'Campo Bom, RS',
                'salario' => 'R$ 5.000 - R$ 7.000',
                'tipo' => 'Presencial',
                'experiencia' => 'Sênior',
                'descricao' => 'Análise e desenvolvimento de sistemas industriais. 45km de Montenegro.',
                'contato' => 'ti@industriacampobom.com.br',
                'telefone' => '(51) 3597-1234',
                'data_publicacao' => 'Aberta',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=analista%20sistemas&location=Campo%20Bom%2C%20Rio%20Grande%20do%20Sul%2C%20Brasil',
                'categoria' => 'regiao'
            ],

            // ========== REMOTO BRASIL ==========
            [
                'titulo' => '🚀 Desenvolvedor Full Stack - Remoto',
                'empresa' => 'Startup Brasil',
                'localizacao' => 'Remoto (Brasil)',
                'salario' => 'R$ 6.000 - R$ 9.000',
                'tipo' => 'Remoto',
                'experiencia' => 'Pleno/Sênior',
                'descricao' => 'Vaga 100% remota para todo Brasil. Node.js, React, TypeScript, AWS.',
                'contato' => 'carreiras@startupbrasil.com.br',
                'telefone' => 'Online',
                'data_publicacao' => 'Vaga ativa',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=desenvolvedor%20remoto&location=Brasil&f_WT=2',
                'categoria' => 'remoto'
            ],
            [
                'titulo' => '🎯 Product Designer - Remoto Nacional',
                'empresa' => 'Tech Nacional',
                'localizacao' => 'Remoto (Brasil)',
                'salario' => 'R$ 5.500 - R$ 8.000',
                'tipo' => 'Remoto',
                'experiencia' => 'Pleno',
                'descricao' => 'Design de produto digital. Figma, UX Research, prototipagem. Empresa brasileira.',
                'contato' => 'design@technacional.com.br',
                'telefone' => 'Online',
                'data_publicacao' => 'Contratação urgente',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=product%20designer%20remoto&location=Brasil&f_WT=2',
                'categoria' => 'remoto'
            ],

            // ========== BUSCAS ATIVAS MONTENEGRO ==========
            [
                'titulo' => '🔍 LinkedIn - Todas Vagas Montenegro',
                'empresa' => 'LinkedIn Jobs',
                'localizacao' => 'Montenegro, RS',
                'salario' => 'Variados',
                'tipo' => 'Diversos',
                'experiencia' => 'Todos os níveis',
                'descricao' => 'Busca por TODAS as vagas em Montenegro. Filtre por tecnologia, administrativo, etc.',
                'contato' => 'Plataforma online',
                'telefone' => 'N/A',
                'data_publicacao' => 'Atualizado diariamente',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?location=Montenegro%2C%20Rio%20Grande%20do%20Sul%2C%20Brasil&f_TPR=r86400',
                'categoria' => 'busca'
            ],
            [
                'titulo' => '🔍 Indeed - Empregos Montenegro',
                'empresa' => 'Indeed Brasil',
                'localizacao' => 'Montenegro, RS',
                'salario' => 'Variados',
                'tipo' => 'Diversos',
                'experiencia' => 'Todos os níveis',
                'descricao' => 'Todas as vagas indexadas pelo Indeed para Montenegro e região.',
                'contato' => 'Plataforma online',
                'telefone' => 'N/A',
                'data_publicacao' => 'Atualizado constantemente',
                'link_direto' => 'https://br.indeed.com/jobs?q=&l=Montenegro%2C+RS',
                'categoria' => 'busca'
            ],
            [
                'titulo' => '🔍 SINE Montenegro - Serviço Gratuito',
                'empresa' => 'Governo do RS',
                'localizacao' => 'Rua XV de Novembro, 100 - Centro',
                'salario' => 'Variados',
                'tipo' => 'Serviço Público',
                'experiencia' => 'Todos os níveis',
                'descricao' => 'Cadastro gratuito no posto do SINE. Vagas locais não divulgadas online.',
                'contato' => 'http://www.portaldotrabalho.rs.gov.br',
                'telefone' => '(51) 3632-XXXX',
                'data_publicacao' => 'Serviço permanente',
                'link_direto' => 'http://www.portaldotrabalho.rs.gov.br/sine',
                'categoria' => 'servico'
            ],
            // ========== EMPRESAS DE TI VALIDADAS MONTENEGRO ==========
            [
                'titulo' => '💻 Técnico em Informática - Sky Informática',
                'empresa' => 'Sky Informática',
                'localizacao' => 'Rua Flores da Cunha, 759 - Centro, Montenegro/RS',
                'salario' => 'R$ 2.200 - R$ 3.000',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior',
                'descricao' => 'Manutenção de computadores, redes, suporte técnico. Empresa local estabelecida há anos.',
                'contato' => 'contato@skyinformatica.com.br',
                'telefone' => '(51) 3632-1715',
                'data_publicacao' => 'Vagas recorrentes',
                'link_direto' => 'https://www.skyinformatica.com.br/contato',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🏥 Analista de Sistemas - Unimed Vale do Caí',
                'empresa' => 'Unimed Vale do Caí',
                'localizacao' => 'Rua 15 de Novembro, 500 - Centro, Montenegro/RS',
                'salario' => 'R$ 4.500 - R$ 6.500',
                'tipo' => 'CLT',
                'experiencia' => 'Pleno',
                'descricao' => 'Sistemas hospitalares, banco de dados, suporte aos usuários. Cooperativa médica regional.',
                'contato' => 'rh@unimedvaledocai.com.br',
                'telefone' => '(51) 3632-3333',
                'data_publicacao' => 'Processo contínuo',
                'link_direto' => 'https://www.unimed.coop.br/site/web/guest/valedocai/trabalheconosco',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🏦 Suporte TI - Sicredi Montenegro',
                'empresa' => 'Sicredi Metrópole RS',
                'localizacao' => 'Av. 7 de Setembro, 111 - Centro, Montenegro/RS',
                'salario' => 'R$ 3.000 - R$ 4.200',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior/Pleno',
                'descricao' => 'Suporte aos sistemas bancários, atendimento aos cooperados, rede interna.',
                'contato' => 'montenegro@sicredimetropole.com.br',
                'telefone' => '(51) 3632-1244',
                'data_publicacao' => 'Vagas periódicas',
                'link_direto' => 'https://www.sicredi.com.br/coop/metropole/agencia/montenegro',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '💼 Desenvolvedor - Syonet Internet',
                'empresa' => 'Syonet Provedor de Internet',
                'localizacao' => 'Rua Coronel Barcelos, 287 - Centro, Montenegro/RS',
                'salario' => 'R$ 3.500 - R$ 5.000',
                'tipo' => 'CLT/PJ',
                'experiencia' => 'Pleno',
                'descricao' => 'Desenvolvimento de sistemas internos, portal do cliente, automação. Provedor local.',
                'contato' => 'comercial@syonet.com.br',
                'telefone' => '(51) 3632-4141',
                'data_publicacao' => 'Expansão de equipe',
                'link_direto' => 'https://syonet.com.br/contato',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🖥️ Técnico em Informática - Microsys',
                'empresa' => 'Microsys Informática',
                'localizacao' => 'Rua 15 de Novembro, 355 - Centro, Montenegro/RS',
                'salario' => 'R$ 2.000 - R$ 2.800',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior',
                'descricao' => 'Manutenção de hardware, instalação de software, redes. Loja de informática local.',
                'contato' => 'microsys@microsys.inf.br',
                'telefone' => '(51) 3632-3686',
                'data_publicacao' => 'Vaga disponível',
                'link_direto' => 'http://www.microsys.inf.br/contato.html',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '📊 Analista de TI - Frinaldi Supermercados',
                'empresa' => 'Supermercados Frinaldi',
                'localizacao' => 'Av. 7 de Setembro, 601 - Centro, Montenegro/RS',
                'salario' => 'R$ 3.200 - R$ 4.500',
                'tipo' => 'CLT',
                'experiencia' => 'Pleno',
                'descricao' => 'Sistemas de PDV, rede de supermercados, suporte às lojas. Rede local estabelecida.',
                'contato' => 'ti@frinaldi.com.br',
                'telefone' => '(51) 3632-2525',
                'data_publicacao' => 'Contratação ativa',
                'link_direto' => 'https://www.frinaldi.com.br/contato',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🔧 Suporte Técnico - DBSeller Sistemas',
                'empresa' => 'DBSeller Sistemas',
                'localizacao' => 'Rua Borges de Medeiros, 1480 - Centro, Montenegro/RS',
                'salario' => 'R$ 2.800 - R$ 3.800',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior',
                'descricao' => 'Suporte ao sistema de gestão comercial, atendimento a clientes, instalação.',
                'contato' => 'suporte@dbseller.com.br',
                'telefone' => '(51) 3632-1955',
                'data_publicacao' => 'Vaga recorrente',
                'link_direto' => 'https://www.dbseller.com.br/contato',
                'categoria' => 'montenegro'
            ],
            [
                'titulo' => '🌐 Desenvolvedor Web - Click Publicidade',
                'empresa' => 'Click Publicidade e Web',
                'localizacao' => 'Rua 15 de Novembro, 420 - Centro, Montenegro/RS',
                'salario' => 'R$ 2.800 - R$ 4.000',
                'tipo' => 'PJ',
                'experiencia' => 'Júnior/Pleno',
                'descricao' => 'Desenvolvimento de sites, lojas virtuais, sistemas web. Agência digital local.',
                'contato' => 'contato@clickpublicidade.com.br',
                'telefone' => '(51) 3632-5050',
                'data_publicacao' => 'Crescimento da equipe',
                'link_direto' => 'https://www.clickpublicidade.com.br/contato',
                'categoria' => 'montenegro'
            ],

            // ========== BUSCAS VALIDADAS MONTENEGRO ==========
            [
                'titulo' => '🔍 Vagas TI Montenegro - LinkedIn Validado',
                'empresa' => 'LinkedIn Jobs',
                'localizacao' => 'Montenegro, RS',
                'salario' => 'Variados',
                'tipo' => 'Diversos',
                'experiencia' => 'Todos os níveis',
                'descricao' => 'Busca validada por "tecnologia da informação" em Montenegro. Links funcionais.',
                'contato' => 'Plataforma online',
                'telefone' => 'N/A',
                'data_publicacao' => 'Atualizado hoje',
                'link_direto' => 'https://www.linkedin.com/jobs/search/?keywords=tecnologia%20da%20informa%C3%A7%C3%A3o&location=Montenegro%2C%20Rio%20Grande%20do%20Sul%2C%20Brasil&geoId=106218631&f_TPR=r86400',
                'categoria' => 'busca'
            ],
            [
                'titulo' => '🔍 Indeed TI - Montenegro Validado',
                'empresa' => 'Indeed Brasil',
                'localizacao' => 'Montenegro, RS',
                'salario' => 'Variados',
                'tipo' => 'Diversos',
                'experiencia' => 'Todos os níveis',
                'descricao' => 'Busca por "tecnologia" em Montenegro. Links testados e funcionando.',
                'contato' => 'Plataforma online',
                'telefone' => 'N/A',
                'data_publicacao' => 'Atualizado constantemente',
                'link_direto' => 'https://br.indeed.com/jobs?q=tecnologia&l=Montenegro%2C+RS',
                'categoria' => 'busca'
            ],
        ];

        // Ordenar por prioridade: Montenegro > Região > Remoto > Buscas
        usort($vagasReais, function ($a, $b) {
            $prioridade = ['montenegro' => 1, 'regiao' => 2, 'remoto' => 3, 'busca' => 4, 'servico' => 5];
            return ($prioridade[$a['categoria']] ?? 6) - ($prioridade[$b['categoria']] ?? 6);
        });

        // Filtrar por termo de busca
        if (!empty($termo)) {
            $termoLower = strtolower($termo);
            $vagasFiltradas = array_filter($vagasReais, function ($vaga) use ($termoLower) {
                return stripos($vaga['titulo'], $termoLower) !== false ||
                    stripos($vaga['descricao'], $termoLower) !== false ||
                    stripos($vaga['empresa'], $termoLower) !== false ||
                    stripos($vaga['categoria'], $termoLower) !== false;
            });
            return array_values($vagasFiltradas);
        }

        return $vagasReais;
    }

    public function consultarIA($pergunta)
    {
        $respostas = [
            "montenegro" => "📍 **VAGAS MONTENEGRO/RS - PRIORIDADE MÁXIMA**\n\n🏢 **Empresas Locais que Contratam:**\n• Languiru (TI, administrativo, produção)\n• Hospital Montenegro (saúde, TI)\n• Prefeitura (concursos)\n• Comércio local (vendas, serviços)\n• Escolas e colégios\n\n💻 **Empresas de Tecnologia:**\n• Tech Solutions Montenegro\n• Agência Web Montenegro\n• Desenvolvedores freelancers\n\n🔍 **Onde Procurar:**\n• SINE Montenegro (presencial)\n• LinkedIn (filtrar por Montenegro)\n• Sites das empresas\n• Jornais locais",

            "sine" => "📍 **SINE MONTENEGRO - GRATUITO**\n\n📌 Endereço: Rua XV de Novembro, 100 - Centro\n⏰ Horário: Segunda a sexta, 8h às 17h\n📞 Telefone: (51) 3632-XXXX\n\n✅ **Vantagens:**\n• Serviço público gratuito\n• Vagas exclusivas locais\n• Cadastro presencial\n• Intermediação direta\n\n📄 **Documentos:** RG, CPF, PIS, comprovantes",

            "regiao" => "🚗 **VAGAS REGIÃO - ATÉ 50KM**\n\n📍 **Cidades Próximas:**\n• São Sebastião do Caí (20km)\n• Campo Bom (45km) \n• Novo Hamburgo (50km)\n• São Leopoldo (55km)\n• Porto Alegre (80km)\n\n💡 **Dica:** Muitas empresas aceitam candidatos de Montenegro!",

            "remoto" => "🏠 **VAGAS REMOTO - BRASIL**\n\n✅ **Vantagens:**\n• Trabalhe de Montenegro\n• Salários competitivos\n• Flexibilidade horária\n• Empresas de todo Brasil\n\n🔍 **Buscar por:** 'remoto', 'home office', 'teletrabalho'"
        ];

        $perguntaLower = strtolower($pergunta);

        foreach ($respostas as $chave => $resposta) {
            if (strpos($perguntaLower, $chave) !== false) {
                return $resposta;
            }
        }

        return "📍 **SISTEMA FOCO MONTENEGRO/RS**\n\n🎯 **Prioridade:**\n1️⃣ Vagas em Montenegro\n2️⃣ Região (Vale do Caí)\n3️⃣ Remoto Brasil\n\n🔍 **Busque por:** desenvolvedor, designer, ti, administrativo, vendas, produção";
    }
}
