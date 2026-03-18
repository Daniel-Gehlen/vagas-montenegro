<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/Logger.php';

class VagaModel
{
    private $db;
    private $cacheDir;
    private $logger;

    // URL do portal central de vagas de Montenegro/RS para scraping
    private $empresasMontenegro = [
        'Prefeitura de Montenegro' => 'https://www.montenegro.rs.gov.br/editais/',
        'JBS Montenegro'           => 'https://www.jbs.com.br/carreiras',
        'Unimed Vale do Caí'       => 'https://unimedvaledocai.com.br/trabalhe-conosco/',
        'Lojas Quero-Quero'        => 'https://www.quero-quero.com.br/trabalhe-conosco',
        'Syonet'                   => 'https://syonet.com.br/trabalhe-conosco',
        'Magazine Luiza'           => 'https://carreiras.magazineluiza.com.br/',
        'John Deere'               => 'https://www.deere.com.br/pt/carreiras/',
        'RH Mattos'                => 'https://www.rhmatos.com.br/vagas',
        'RH CENTER'                => 'https://rhcenterrs.com.br/vagas',
        'RHF TALENTOS'             => 'https://www.rhftalentos.com.br/vagas',
        'SINE Montenegro'          => 'https://empregabrasil.mte.gov.br/',
        'Sine Digital RS'          => 'https://sine.rs.gov.br/',
    ];

    private $contatosEmpresa = [
        'Prefeitura' => 'editais@montenegro.rs.gov.br',
        'JBS'        => 'rh@jbs.com.br',
        'Unimed'     => 'rh@unimedvaledocai.com.br',
    ];

    private $telefonesEmpresa = [
        'Prefeitura' => '(51) 3632-1000',
        'SINE'       => '(51) 3632-9988',
    ];

    private $categoriasEmpresa = [
        'Prefeitura' => 'público',
        'JBS'        => 'indústria',
        'Unimed'     => 'saúde',
        'Quero-Quero' => 'comércio',
        'Syonet'     => 'tecnologia',
        'Magazine'    => 'comércio',
        'John Deere' => 'indústria',
        'SINE'       => 'geral',
        'Sine'       => 'geral',
        'RH'         => 'geral',
    ];

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->logger = Logger::getInstance();
        $this->cacheDir = __DIR__ . '/../../cache/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    /**
     * Retorna vagas do cache SQLite. Se o cache estiver vazio, dispara scraping
     * assíncrono em background para preencher nos próximos pedidos.
     */
    public function buscarVagasReais($termo = '')
    {
        $vagasCached = $this->buscarVagasCache($termo);

        // Serve do cache se tiver dados suficientes
        if (count($vagasCached) >= 3) {
            return $vagasCached;
        }

        // Cache vazio ou insuficiente: scraping de apenas 2 sites por request
        // para responder rápido. Rotation garante que todos os sites sejam cobertos.
        $this->scraperParcial($termo, 2);

        // Retorna o que existe agora
        return $this->buscarVagasCache($termo);
    }

    /**
     * Scraping parcial: busca em N sites por request, rotacionando via hora do dia.
     */
    private function scraperParcial($termo, $n = 2)
    {
        $keys  = array_keys($this->empresasMontenegro);
        $total = count($keys);
        // Offset rotativo para cobrir empresas diferentes em cada hora
        $offset = (int)(date('H') * $n) % $total;

        $verificadas = 0;
        for ($i = 0; $i < $total && $verificadas < $n; $i++) {
            $idx    = ($offset + $i) % $total;
            $empresa = $keys[$idx];
            $url    = $this->empresasMontenegro[$empresa];

            if ($this->vagaJaExiste($url)) continue;

            $vaga = $this->verificarVagasEmpresa($empresa, $url, $termo);
            if ($vaga) {
                $this->salvarVaga($vaga);
            }
            $verificadas++;
        }
    }

    private function buscarVagasCache($termo = '')
    {
        $cacheKey = 'vagas_' . md5($termo);
        $cached = $this->getCache($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $sql  = "SELECT * FROM vagas
                 WHERE (titulo LIKE :termo OR descricao LIKE :termo OR empresa LIKE :termo)
                 ORDER BY created_at DESC
                 LIMIT 30";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['termo' => "%$termo%"]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->setCache($cacheKey, $result, 300); // 5 minutes
        return $result;
    }

    private function getCache($key)
    {
        $file = $this->cacheDir . $key . '.cache';
        if (file_exists($file) && (time() - filemtime($file)) < 300) {
            return unserialize(file_get_contents($file));
        }
        return null;
    }

    private function setCache($key, $data, $ttl = 300)
    {
        $file = $this->cacheDir . $key . '.cache';
        file_put_contents($file, serialize($data));
    }

    private function vagaJaExiste($url)
    {
        $stmt = $this->db->prepare("SELECT id FROM vagas WHERE link_direto = ? AND date(created_at) >= date('now','-1 day')");
        $stmt->execute([$url]);
        return $stmt->fetch() !== false;
    }

    private function salvarVaga($vaga)
    {
        try {
            $sql  = "INSERT OR REPLACE INTO vagas
                        (titulo, empresa, localizacao, salario, tipo, experiencia,
                         descricao, contato, telefone, data_publicacao, link_direto, fonte, categoria)
                     VALUES
                        (:titulo, :empresa, :localizacao, :salario, :tipo, :experiencia,
                         :descricao, :contato, :telefone, :data_publicacao, :link_direto, :fonte, :categoria)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($vaga);
        } catch (PDOException $e) {
            // silently ignore
        }
    }

    private function verificarVagasEmpresa($empresa, $url, $termo)
    {
        $html = $this->fetchUrlContent($url);
        if (!$html || strlen($html) < 200) {
            // Site offline – não criar placeholder para evitar links quebrados
            return null;
        }

        // Tenta extrair links que pareçam vagas reais
        $vagaLink = $this->extrairLinkVaga($html, $url, $termo);
        if ($vagaLink['link'] === $url) {
            // Se não encontrou vaga específica, não criar entrada
            return null;
        }

        return [
            'titulo'          => $vagaLink['titulo'],
            'empresa'         => $empresa,
            'localizacao'     => 'Montenegro, RS',
            'salario'         => 'A combinar',
            'tipo'            => 'CLT',
            'experiencia'     => 'Verificar no site',
            'descricao'       => "Oportunidade identificada no portal oficial de $empresa.",
            'contato'         => $this->getInfo($this->contatosEmpresa, $empresa, 'Consulte o site oficial'),
            'telefone'        => $this->getInfo($this->telefonesEmpresa, $empresa, ''),
            'data_publicacao' => date('d/m/Y'),
            'link_direto'     => $vagaLink['link'],
            'fonte'           => 'Site Oficial',
            'categoria'       => $this->getInfo($this->categoriasEmpresa, $empresa, 'diversos'),
        ];
    }

    /**
     * Extrai o link mais relevante de uma página de vagas.
     * Fallback para a URL base se não achar link específico.
     */
    private function extrairLinkVaga($html, $urlBase, $termo)
    {
        $indicadores = [
            'vaga', 'oportunidade', 'analista', 'assistente', 'auxiliar', 'gerente',
            'técnico', 'tecnico', 'desenvolvedor', 'vendedor', 'operador', 'médico',
            'enfermeiro', 'programador', 'motorista', 'estoquista', 'atendente'
        ];

        if ($termo) {
            $indicadores = array_merge([strtolower($termo)], $indicadores);
        }

        if (preg_match_all('/<a[^>]+href=[\'"]([^\'"#][^\'"]*)[\'"][^>]*>(.*?)<\/a>/is', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $href      = trim($match[1]);
                $texto     = trim(strip_tags($match[2]));
                $textoBaixo = strtolower($texto);

                // Ignorar links de navegação
                if (strlen($texto) < 5) continue;
                if (preg_match('/(login|logout|cadastr|sobre|home|menu|contact|cookie|privacidade|politica)/i', $textoBaixo)) continue;

                // Normalizar URL relativa
                if (!preg_match('~^https?://~i', $href)) {
                    $p    = parse_url($urlBase);
                    $base = $p['scheme'] . '://' . $p['host'];
                    $href = $base . '/' . ltrim($href, '/');
                }

                foreach ($indicadores as $ind) {
                    if (strpos($textoBaixo, $ind) !== false) {
                        return ['titulo' => $texto, 'link' => $href];
                    }
                }
            }
        }

        // Fallback: retorna o próprio portal
        return ['titulo' => 'Vagas Disponíveis', 'link' => $urlBase];
    }

    private function fetchUrlContent($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 3,       // 3 segundos máximo
            CURLOPT_CONNECTTIMEOUT => 2,       // 2 segundos conexão
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; VagasMontenegroBot/1.0)',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 2,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING       => 'gzip',
        ]);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content ?: '';
    }

    private function getInfo(array $map, string $empresa, string $default): string
    {
        foreach ($map as $chave => $valor) {
            if (stripos($empresa, $chave) !== false) return $valor;
        }
        return $default;
    }

    /**
     * Assistente IA: busca vagas baseado na pergunta do usuário.
     */
    public function consultarIA($pergunta)
    {
        $stopWords = ['vagas', 'tem', 'hoje', 'para', 'de', 'em', 'trabalho', 'aqui', 'quero', 'preciso', 'encontrar', 'como'];
        $termos    = preg_split('/\s+/', strtolower(preg_replace('/[^\w\s\x{00C0}-\x{017E}]/u', '', $pergunta)));

        $termoBusca = '';
        foreach ($termos as $t) {
            if (strlen($t) > 3 && !in_array($t, $stopWords)) {
                $termoBusca = $t;
                break;
            }
        }

        $vagas = $this->buscarVagasReais($termoBusca);

        if (count($vagas) === 0) {
            return "Pesquisei nos portais oficiais de Montenegro/RS e não encontrei vagas publicadas para '" .
                   ($termoBusca ?: 'sua busca') .
                   "' no momento. Tente outro cargo ou volte mais tarde — o sistema verifica novos anúncios a cada hora!";
        }

        $resposta = "Encontrei " . count($vagas) . " oportunidade(s) para sua busca:\n\n";
        $limite   = min(3, count($vagas));

        for ($i = 0; $i < $limite; $i++) {
            $v        = $vagas[$i];
            $resposta .= "• **{$v['titulo']}** — {$v['empresa']}\n";
        }

        if (count($vagas) > $limite) {
            $resto     = count($vagas) - $limite;
            $resposta .= "\nMais $resto vaga(s) aparecem no painel de resultados acima. Boa sorte!";
        } else {
            $resposta .= "\nClique nos cards acima para acessar o site oficial de cada empresa!";
        }

        return $resposta;
    }
}
