<?php
require_once __DIR__ . '/../config/Logger.php';

class WebhooksController {
    private $logger;

    public function __construct() {
        $this->logger = new Logger();
    }

    public function receberWebhook() {
        try {
            $this->logger->info("Recebendo webhook de fonte externa");

            $payload = file_get_contents('php://input');
            $data = json_decode($payload, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Payload JSON inválido');
            }

            $this->processarWebhook($data);

            $this->logger->info("Webhook processado com sucesso");

            http_response_code(200);
            echo json_encode(['sucesso' => true, 'mensagem' => 'Webhook processado']);
        } catch (Exception $e) {
            $this->logger->error("Erro no webhook: " . $e->getMessage());

            http_response_code(500);
            echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
        }
    }

    public function registrarWebhook() {
        try {
            $this->logger->info("Registrando novo webhook");

            $dados = json_decode(file_get_contents('php://input'), true);

            if (!$this->validarWebhook($dados)) {
                throw new Exception('Dados de webhook inválidos');
            }

            $this->salvarWebhook($dados);

            $this->logger->info("Webhook registrado com sucesso");

            http_response_code(201);
            echo json_encode(['sucesso' => true, 'mensagem' => 'Webhook registrado']);
        } catch (Exception $e) {
            $this->logger->error("Erro ao registrar webhook: " . $e->getMessage());

            http_response_code(500);
            echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
        }
    }

    private function processarWebhook($data) {
        $this->logger->debug("Processando webhook: " . json_encode($data));

        // Lógica de processamento do webhook
        switch ($data['tipo'] ?? '') {
            case 'nova_vaga':
                $this->processarNovaVaga($data);
                break;
            case 'atualizacao_vaga':
                $this->processarAtualizacaoVaga($data);
                break;
            case 'exclusao_vaga':
                $this->processarExclusaoVaga($data);
                break;
            default:
                $this->logger->warning("Tipo de webhook desconhecido: " . ($data['tipo'] ?? ''));
        }
    }

    private function processarNovaVaga($data) {
        $this->logger->info("Processando nova vaga: " . ($data['titulo'] ?? ''));
        // Lógica para processar nova vaga
    }

    private function processarAtualizacaoVaga($data) {
        $this->logger->info("Processando atualização de vaga: " . ($data['id'] ?? ''));
        // Lógica para processar atualização de vaga
    }

    private function processarExclusaoVaga($data) {
        $this->logger->info("Processando exclusão de vaga: " . ($data['id'] ?? ''));
        // Lógica para processar exclusão de vaga
    }

    private function validarWebhook($dados) {
        if (!isset($dados['url']) || !filter_var($dados['url'], FILTER_VALIDATE_URL)) {
            return false;
        }

        if (!isset($dados['eventos']) || !is_array($dados['eventos'])) {
            return false;
        }

        return true;
    }

    private function salvarWebhook($dados) {
        // Lógica para salvar webhook no banco de dados
        $this->logger->debug("Salvando webhook: " . json_encode($dados));
    }
}
?>
