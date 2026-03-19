<?php
require_once __DIR__ . '/../config/database.php';

class VagaModel {
    private $db;
    private $cache = [];
    private $cache_ttl = 300; // 5 minutos

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function listar($pagina = 1, $limite = 10, $termo = '') {
        $cache_key = "vagas_{$pagina}_{$limite}_{$termo}";

        if (isset($this->cache[$cache_key]) &&
            (time() - $this->cache[$cache_key]['timestamp']) < $this->cache_ttl) {
            return $this->cache[$cache_key]['data'];
        }

        $offset = ($pagina - 1) * $limite;
        $sql = "SELECT * FROM vagas
                WHERE titulo LIKE :termo OR empresa LIKE :termo OR descricao LIKE :termo
                ORDER BY created_at DESC
                LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':termo', "%{$termo}%");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cache the result
        $this->cache[$cache_key] = [
            'data' => $result,
            'timestamp' => time()
        ];

        return $result;
    }

    public function contarTotal($termo = '') {
        $sql = "SELECT COUNT(*) as total FROM vagas WHERE titulo LIKE :termo OR empresa LIKE :termo OR descricao LIKE :termo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':termo', "%{$termo}%");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function buscar($id) {
        $sql = "SELECT * FROM vagas WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados) {
        $this->limparCache();

        $sql = "INSERT INTO vagas (titulo, empresa, descricao, localizacao, salario, tipo, experiencia, contato, telefone, data_publicacao, link_direto, fonte, categoria)
                VALUES (:titulo, :empresa, :descricao, :localizacao, :salario, :tipo, :experiencia, :contato, :telefone, :data_publicacao, :link_direto, :fonte, :categoria)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titulo', $dados['titulo']);
        $stmt->bindValue(':empresa', $dados['empresa']);
        $stmt->bindValue(':descricao', $dados['descricao']);
        $stmt->bindValue(':localizacao', $dados['localizacao']);
        $stmt->bindValue(':salario', $dados['salario']);
        $stmt->bindValue(':tipo', $dados['tipo']);
        $stmt->bindValue(':experiencia', $dados['experiencia']);
        $stmt->bindValue(':contato', $dados['contato']);
        $stmt->bindValue(':telefone', $dados['telefone']);
        $stmt->bindValue(':data_publicacao', $dados['data_publicacao']);
        $stmt->bindValue(':link_direto', $dados['link_direto']);
        $stmt->bindValue(':fonte', $dados['fonte']);
        $stmt->bindValue(':categoria', $dados['categoria']);

        return $stmt->execute();
    }

    public function atualizar($id, $dados) {
        $this->limparCache();

        $sql = "UPDATE vagas SET titulo = :titulo, empresa = :empresa, descricao = :descricao,
                localizacao = :localizacao, salario = :salario, tipo = :tipo, experiencia = :experiencia,
                contato = :contato, telefone = :telefone, data_publicacao = :data_publicacao,
                link_direto = :link_direto, fonte = :fonte, categoria = :categoria
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':titulo', $dados['titulo']);
        $stmt->bindValue(':empresa', $dados['empresa']);
        $stmt->bindValue(':descricao', $dados['descricao']);
        $stmt->bindValue(':localizacao', $dados['localizacao']);
        $stmt->bindValue(':salario', $dados['salario']);
        $stmt->bindValue(':tipo', $dados['tipo']);
        $stmt->bindValue(':experiencia', $dados['experiencia']);
        $stmt->bindValue(':contato', $dados['contato']);
        $stmt->bindValue(':telefone', $dados['telefone']);
        $stmt->bindValue(':data_publicacao', $dados['data_publicacao']);
        $stmt->bindValue(':link_direto', $dados['link_direto']);
        $stmt->bindValue(':fonte', $dados['fonte']);
        $stmt->bindValue(':categoria', $dados['categoria']);

        return $stmt->execute();
    }

    public function excluir($id) {
        $this->limparCache();

        $sql = "DELETE FROM vagas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPorCategoria($categoria) {
        $sql = "SELECT * FROM vagas WHERE categoria = :categoria";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':categoria', $categoria);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarRecentes($limite = 5) {
        $sql = "SELECT * FROM vagas
                ORDER BY created_at DESC
                LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function limparCache() {
        $this->cache = [];
    }
}
?>
