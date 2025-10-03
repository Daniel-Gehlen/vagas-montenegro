<?php
// Inclui todos os arquivos necessários
require_once 'api/models/VagaModel.php';
require_once 'api/controllers/VagasController.php';

header('Content-Type: text/html; charset=utf-8');

// Roteamento
$path = $_SERVER['REQUEST_URI'] ?? '';

// Serve arquivos estáticos (CSS, JS)
if (preg_match('/\.(css|js)$/', $path)) {
    $file_path = ltrim($path, '/');
    if (file_exists($file_path)) {
        if (strpos($path, '.css') !== false) {
            header('Content-Type: text/css');
        } elseif (strpos($path, '.js') !== false) {
            header('Content-Type: application/javascript');
        }
        readfile($file_path);
    } else {
        http_response_code(404);
        echo "Arquivo não encontrado: " . $file_path;
    }
    exit;
}

// API routes
if (isset($_GET['api']) && $_GET['api'] === 'buscar') {
    header('Content-Type: application/json');
    $vagaModel = new VagaModel();
    $termo = $_GET['termo'] ?? '';
    echo json_encode($vagaModel->buscarVagasReais($termo));
    exit;
}

// Serve HTML com base URL corrigida
$html = file_get_contents('index.html');
// Corrige caminhos CSS/JS
$html = str_replace(
    ['href="css/', 'src="js/'],
    ['href="/css/', 'src="/js/'],
    $html
);
echo $html;
exit;
