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

    public function perguntarIA() {
        try {
            $dados = json_decode(file_get_contents('php://input'), true);
            $pergunta = $dados['pergunta'] ?? '';

            if (empty($pergunta)) {
                throw new Exception('Pergunta não fornecida');
            }

            $this->logger->info("Pergunta recebida: " . $pergunta);

            // Resposta simulada da IA (substituir por integração real)
            $resposta = $this->gerarRespostaIA($pergunta);

            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'resposta' => $resposta
            ]);
        } catch (Exception $e) {
            $this->logger->error("Erro na pergunta IA: " . $e->getMessage());

            http_response_code(500);
            echo json_encode([
                'sucesso' => false,
                'erro' => $e->getMessage()
            ]);
        }
    }

    private function gerarRespostaIA($pergunta) {
        // Respostas simuladas baseadas em palavras-chave
        $pergunta_lower = strtolower($pergunta);

        if (strpos($pergunta_lower, 'vaga') !== false || strpos($pergunta_lower, 'emprego') !== false) {
            return "Temos diversas vagas disponíveis em Montenegro/RS. Você pode usar a busca para filtrar por categoria, tipo de contrato ou nível de experiência. Posso ajudar com alguma categoria específica?";
        }

        if (strpos($pergunta_lower, 'salário') !== false || strpos($pergunta_lower, 'salario') !== false) {
            return "Os salários variam conforme a posição e experiência. Na média, temos vagas que vão de R$ 2.000 a R$ 8.000. Posso filtrar vagas por faixa salarial se desejar.";
        }

        if (strpos($pergunta_lower, 'tecnologia') !== false || strpos($pergunta_lower, 'ti') !== false) {
            return "Temos ótimas oportunidades em tecnologia! Desenvolvedores, analistas de sistemas e suporte técnico são as mais procuradas. Quer que eu liste as vagas de tecnologia disponíveis?";
        }

        if (strpos($pergunta_lower, 'ajuda') !== false) {
            return "Posso ajudar você a encontrar vagas de emprego em Montenegro/RS. Você pode me perguntar sobre: vagas disponíveis, salários, tipos de contrato, categorias específicas ou requisitos. Como posso ajudar?";
        }

        return "Entendi sua pergunta sobre '{$pergunta}'. Posso ajudar você a encontrar vagas de emprego em Montenegro/RS. Tente usar termos como 'vaga', 'emprego', 'salário' ou nome de uma categoria para uma busca mais específica.";
    }
}
?>
