<?php
require_once __DIR__ . '/config/Logger.php';

// Configurar cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Tratamento de requisições OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Inicializar logger
$logger = new Logger();

try {
    // Registrar requisição
    $logger->info("Requisição: {$_SERVER['REQUEST_METHOD']} {$_SERVER['REQUEST_URI']}");

    // Roteamento por action query parameter (compatibilidade com frontend)
    $action = $_GET['action'] ?? '';
    $method = $_SERVER['REQUEST_METHOD'];

    // Importar controlador
    require_once 'controllers/VagasController.php';
    $controller = new VagasController();

    // Roteamento por action
    if ($action === 'buscarVagas' && $method === 'POST') {
        $controller->listar();
        exit;
    }

    if ($action === 'perguntarIA' && $method === 'POST') {
        require_once 'controllers/WebhooksController.php';
        $webhooksController = new WebhooksController();
        $webhooksController->perguntarIA();
        exit;
    }

    // Roteamento por PATH_INFO (REST)
    $path = $_SERVER['PATH_INFO'] ?? '';

    switch ($path) {
        case '/vagas':
            if ($method === 'GET') {
                $controller->listar();
            } elseif ($method === 'POST') {
                $controller->criar();
            } else {
                throw new Exception('Método não permitido');
            }
            break;

        case '/vagas/buscar':
            if ($method === 'GET') {
                $controller->buscar();
            } else {
                throw new Exception('Método não permitido');
            }
            break;

        case '/vagas/atualizar':
            if ($method === 'PUT') {
                $controller->atualizar();
            } else {
                throw new Exception('Método não permitido');
            }
            break;

        case '/vagas/excluir':
            if ($method === 'DELETE') {
                $controller->excluir();
            } else {
                throw new Exception('Método não permitido');
            }
            break;

        case '/vagas/categoria':
            if ($method === 'GET') {
                $controller->buscarPorCategoria();
            } else {
                throw new Exception('Método não permitido');
            }
            break;

        case '/vagas/recentes':
            if ($method === 'GET') {
                $controller->buscarRecentes();
            } else {
                throw new Exception('Método não permitido');
            }
            break;

        default:
            if (empty($action) && empty($path)) {
                throw new Exception('Rota não encontrada');
            }
            break;
    }

} catch (Exception $e) {
    $logger->error("Erro na requisição: " . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'sucesso' => false,
        'erro' => 'Erro interno do servidor'
    ]);
}
?>
