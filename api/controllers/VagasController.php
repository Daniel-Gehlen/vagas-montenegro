<?php
require_once __DIR__ . '/../models/VagaModel.php';
require_once __DIR__ . '/../config/Logger.php';

class VagasController {
    private $model;
    private $logger;

    public function __construct() {
        $this->model = new VagaModel();
        $this->logger = new Logger();
    }

    public function listar() {
        try {
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
            $termo = isset($_GET['termo']) ? $_GET['termo'] : '';

            $this->logger->info("Listando vagas - página: {$pagina}, limite: {$limite}, termo: {$termo}");

            $vagas = $this->model->listar($pagina, $limite, $termo);
            $total = $this->model->contarTotal($termo);

            $this->responderSucesso([
                'vagas' => $vagas,
                'total' => $total,
                'pagina' => $pagina,
                'limite' => $limite,
                'total_paginas' => ceil($total / $limite)
            ]);
        } catch (Exception $e) {
            $this->logger->error("Erro ao listar vagas: " . $e->getMessage());
            $this->responderErro('Erro ao listar vagas', 500);
        }
    }

    public function buscar() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

            if ($id <= 0) {
                $this->responderErro('ID inválido', 400);
                return;
            }

            $this->logger->info("Buscando vaga com ID: {$id}");

            $vaga = $this->model->buscar($id);

            if (!$vaga) {
                $this->responderErro('Vaga não encontrada', 404);
                return;
            }

            $this->responderSucesso($vaga);
        } catch (Exception $e) {
            $this->logger->error("Erro ao buscar vaga: " . $e->getMessage());
            $this->responderErro('Erro ao buscar vaga', 500);
        }
    }

    public function criar() {
        try {
            $dados = json_decode(file_get_contents('php://input'), true);

            if (!$this->validarDados($dados)) {
                $this->responderErro('Dados inválidos', 400);
                return;
            }

            $this->logger->info("Criando nova vaga: " . json_encode($dados));

            if ($this->model->criar($dados)) {
                $this->logger->info("Vaga criada com sucesso");
                $this->responderSucesso(['mensagem' => 'Vaga criada com sucesso']);
            } else {
                $this->logger->warning("Falha ao criar vaga");
                $this->responderErro('Falha ao criar vaga', 500);
            }
        } catch (Exception $e) {
            $this->logger->error("Erro ao criar vaga: " . $e->getMessage());
            $this->responderErro('Erro ao criar vaga', 500);
        }
    }

    public function atualizar() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $dados = json_decode(file_get_contents('php://input'), true);

            if ($id <= 0) {
                $this->responderErro('ID inválido', 400);
                return;
            }

            if (!$this->validarDados($dados)) {
                $this->responderErro('Dados inválidos', 400);
                return;
            }

            $this->logger->info("Atualizando vaga ID: {$id} com dados: " . json_encode($dados));

            if ($this->model->atualizar($id, $dados)) {
                $this->logger->info("Vaga atualizada com sucesso");
                $this->responderSucesso(['mensagem' => 'Vaga atualizada com sucesso']);
            } else {
                $this->logger->warning("Falha ao atualizar vaga");
                $this->responderErro('Falha ao atualizar vaga', 500);
            }
        } catch (Exception $e) {
            $this->logger->error("Erro ao atualizar vaga: " . $e->getMessage());
            $this->responderErro('Erro ao atualizar vaga', 500);
        }
    }

    public function excluir() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

            if ($id <= 0) {
                $this->responderErro('ID inválido', 400);
                return;
            }

            $this->logger->info("Excluindo vaga com ID: {$id}");

            if ($this->model->excluir($id)) {
                $this->logger->info("Vaga excluída com sucesso");
                $this->responderSucesso(['mensagem' => 'Vaga excluída com sucesso']);
            } else {
                $this->logger->warning("Falha ao excluir vaga");
                $this->responderErro('Falha ao excluir vaga', 500);
            }
        } catch (Exception $e) {
            $this->logger->error("Erro ao excluir vaga: " . $e->getMessage());
            $this->responderErro('Erro ao excluir vaga', 500);
        }
    }

    public function buscarPorCategoria() {
        try {
            $categoria_id = isset($_GET['categoria_id']) ? (int)$_GET['categoria_id'] : 0;

            if ($categoria_id <= 0) {
                $this->responderErro('ID de categoria inválido', 400);
                return;
            }

            $this->logger->info("Buscando vagas por categoria: {$categoria_id}");

            $vagas = $this->model->buscarPorCategoria($categoria_id);
            $this->responderSucesso(['vagas' => $vagas]);
        } catch (Exception $e) {
            $this->logger->error("Erro ao buscar vagas por categoria: " . $e->getMessage());
            $this->responderErro('Erro ao buscar vagas por categoria', 500);
        }
    }

    public function buscarRecentes() {
        try {
            $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 5;

            $this->logger->info("Buscando {$limite} vagas mais recentes");

            $vagas = $this->model->buscarRecentes($limite);
            $this->responderSucesso(['vagas' => $vagas]);
        } catch (Exception $e) {
            $this->logger->error("Erro ao buscar vagas recentes: " . $e->getMessage());
            $this->responderErro('Erro ao buscar vagas recentes', 500);
        }
    }

    private function validarDados($dados) {
        if (!is_array($dados)) {
            return false;
        }

        $required_fields = ['titulo', 'empresa', 'descricao', 'localizacao', 'salario', 'categoria_id'];

        foreach ($required_fields as $field) {
            if (!isset($dados[$field]) || empty(trim($dados[$field]))) {
                return false;
            }
        }

        if (!is_numeric($dados['salario']) || $dados['salario'] < 0) {
            return false;
        }

        if (!is_numeric($dados['categoria_id']) || $dados['categoria_id'] <= 0) {
            return false;
        }

        return true;
    }

    private function responderSucesso($data) {
        header('Content-Type: application/json');
        http_response_code(200);
        $response = json_encode([
            'sucesso' => true,
            'dados' => $data
        ]);
        echo $response;
        flush();
        exit;
    }

    private function responderErro($mensagem, $codigo = 400) {
        header('Content-Type: application/json');
        http_response_code($codigo);
        echo json_encode([
            'sucesso' => false,
            'erro' => $mensagem
        ]);
        exit;
    }
}
?>
