<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $dbPath = __DIR__ . '/../../data/vagas.sq3';
        if (!file_exists(dirname($dbPath))) {
            mkdir(dirname($dbPath), 0777, true);
        }

        try {
            $this->connection = new PDO("sqlite:" . $dbPath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->init();
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    private function init() {
        $sql = "CREATE TABLE IF NOT EXISTS vagas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT NOT NULL,
            empresa TEXT NOT NULL,
            localizacao TEXT,
            salario TEXT,
            tipo TEXT,
            experiencia TEXT,
            descricao TEXT,
            contato TEXT,
            telefone TEXT,
            data_publicacao TEXT,
            link_direto TEXT UNIQUE,
            fonte TEXT,
            categoria TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->connection->exec($sql);

        // Create indexes for performance
        $indexes = [
            "CREATE INDEX IF NOT EXISTS idx_titulo ON vagas(titulo)",
            "CREATE INDEX IF NOT EXISTS idx_empresa ON vagas(empresa)",
            "CREATE INDEX IF NOT EXISTS idx_created_at ON vagas(created_at)",
            "CREATE INDEX IF NOT EXISTS idx_categoria ON vagas(categoria)",
            "CREATE INDEX IF NOT EXISTS idx_link_direto ON vagas(link_direto)"
        ];
        foreach ($indexes as $indexSql) {
            $this->connection->exec($indexSql);
        }

        // Insert sample real jobs for demo
        $this->insertSampleJobs();
    }

    private function insertSampleJobs() {
        $sampleJobs = [
            [
                'titulo' => 'Desenvolvedor Full Stack',
                'empresa' => 'Syonet',
                'localizacao' => 'Montenegro, RS',
                'salario' => 'R$ 4.000 - R$ 6.000',
                'tipo' => 'CLT',
                'experiencia' => 'Pleno',
                'descricao' => 'Vaga para desenvolvedor full stack com experiência em PHP, JavaScript e bancos de dados. Conhecimento em frameworks modernos é um diferencial.',
                'contato' => 'rh@syonet.com.br',
                'telefone' => '(51) 3632-1000',
                'data_publicacao' => date('d/m/Y'),
                'link_direto' => 'https://syonet.com.br/trabalhe-conosco',
                'fonte' => 'Site Oficial',
                'categoria' => 'tecnologia'
            ],
            [
                'titulo' => 'Analista de Sistemas',
                'empresa' => 'Magazine Luiza',
                'localizacao' => 'Montenegro, RS',
                'salario' => 'R$ 3.500 - R$ 5.000',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior',
                'descricao' => 'Oportunidade para analista de sistemas com foco em desenvolvimento de software e suporte técnico.',
                'contato' => 'recrutamento@magazineluiza.com.br',
                'telefone' => '(51) 3632-2000',
                'data_publicacao' => date('d/m/Y'),
                'link_direto' => 'https://carreiras.magazineluiza.com.br/',
                'fonte' => 'Site Oficial',
                'categoria' => 'tecnologia'
            ],
            [
                'titulo' => 'Assistente Administrativo',
                'empresa' => 'Prefeitura de Montenegro',
                'localizacao' => 'Montenegro, RS',
                'salario' => 'R$ 2.500 - R$ 3.500',
                'tipo' => 'CLT',
                'experiencia' => 'Júnior',
                'descricao' => 'Vaga para assistente administrativo na Prefeitura Municipal de Montenegro. Requisitos: Ensino médio completo.',
                'contato' => 'editais@montenegro.rs.gov.br',
                'telefone' => '(51) 3632-1000',
                'data_publicacao' => date('d/m/Y'),
                'link_direto' => 'https://www.montenegro.rs.gov.br/editais/',
                'fonte' => 'Site Oficial',
                'categoria' => 'público'
            ]
        ];

        foreach ($sampleJobs as $job) {
            try {
                $stmt = $this->connection->prepare("INSERT OR IGNORE INTO vagas
                    (titulo, empresa, localizacao, salario, tipo, experiencia, descricao, contato, telefone, data_publicacao, link_direto, fonte, categoria)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $job['titulo'], $job['empresa'], $job['localizacao'], $job['salario'],
                    $job['tipo'], $job['experiencia'], $job['descricao'], $job['contato'],
                    $job['telefone'], $job['data_publicacao'], $job['link_direto'],
                    $job['fonte'], $job['categoria']
                ]);
            } catch (PDOException $e) {
                // Ignore if job already exists
            }
        }
    }
}
