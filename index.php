<?php
// Inclui todos os arquivos necessários
require_once 'api/models/VagaModel.php';
require_once 'api/controllers/VagasController.php';

// Seu código principal aqui
header('Content-Type: text/html; charset=utf-8');

// Roteamento
$path = $_SERVER['REQUEST_URI'] ?? '';

if (isset($_GET['api']) && $_GET['api'] === 'buscar') {
    header('Content-Type: application/json');
    $vagaModel = new VagaModel();
    $termo = $_GET['termo'] ?? '';
    echo json_encode($vagaModel->buscarVagasReais($termo));
    exit;
}

// Se não for API, mostra o HTML
readfile('index.html');
