<?php
require_once __DIR__ . '/../config/database.php';

class VagaModel {
    private $db;
    private $cache = [];
    private $cache_ttl = 300; // 5 minutos

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function listar($pagina = 1, $limite = 10, $termo = '') {
        $cache_key = "vagas_{$pagina}_{$limite}_{$termo}";

        if (isset($this->cache[$cache_key]) &&
            (time() - $this->cache[$cache_key]['timestamp']) < $this->cache_ttl) {
            return $this->cache[$cache_key]['data'];
        }

        $offset = ($pagina - 1) * $limite;
        $sql = "SELECT v.*, c.nome as categoria_nome
                FROM vagas v
                LEFT JOIN categorias c ON v.categoria_id = c.id
                WHERE v.titulo LIKE :termo
                ORDER BY v.data_criacao DESC
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
        $sql = "SELECT COUNT(*) as total FROM vagas WHERE titulo LIKE :termo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':termo', "%{$termo}%");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function buscar($id) {
        $sql = "SELECT v.*, c.nome as categoria_nome
                FROM vagas v
                LEFT JOIN categorias c ON v.categoria_id = c.id
                WHERE v.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados) {
        $this->limparCache();

        $sql = "INSERT INTO vagas (titulo, empresa, descricao, localizacao, salario, categoria_id, data_criacao)
                VALUES (:titulo, :empresa, :descricao, :localizacao, :salario, :categoria_id, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titulo', $dados['titulo']);
        $stmt->bindValue(':empresa', $dados['empresa']);
        $stmt->bindValue(':descricao', $dados['descricao']);
        $stmt->bindValue(':localizacao', $dados['localizacao']);
        $stmt->bindValue(':salario', $dados['salario']);
        $stmt->bindValue(':categoria_id', $dados['categoria_id']);

        return $stmt->execute();
    }

    public function atualizar($id, $dados) {
        $this->limparCache();

        $sql = "UPDATE vagas SET titulo = :titulo, empresa = :empresa, descricao = :descricao,
                localizacao = :localizacao, salario = :salario, categoria_id = :categoria_id
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':titulo', $dados['titulo']);
        $stmt->bindValue(':empresa', $dados['empresa']);
        $stmt->bindValue(':descricao', $dados['descricao']);
        $stmt->bindValue(':localizacao', $dados['localizacao']);
        $stmt->bindValue(':salario', $dados['salario']);
        $stmt->bindValue(':categoria_id', $dados['categoria_id']);

        return $stmt->execute();
    }

    public function excluir($id) {
        $this->limparCache();

        $sql = "DELETE FROM vagas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPorCategoria($categoria_id) {
        $sql = "SELECT v.*, c.nome as categoria_nome
                FROM vagas v
                LEFT JOIN categorias c ON v.categoria_id = c.id
                WHERE v.categoria_id = :categoria_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarRecentes($limite = 5) {
        $sql = "SELECT v.*, c.nome as categoria_nome
                FROM vagas v
                LEFT JOIN categorias c ON v.categoria_id = c.id
                ORDER BY v.data_criacao DESC
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
