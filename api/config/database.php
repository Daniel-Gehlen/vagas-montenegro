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
    }
}
