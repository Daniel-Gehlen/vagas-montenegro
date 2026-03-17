<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  exit(0);
}

// Incluir model
require_once 'models/VagaModel.php';

$input = json_decode(file_get_contents('php://input'), true);
$action = $_GET['action'] ?? '';

$model = new VagaModel();

switch ($action) {
  case 'buscarVagas':
    $termo = filter_var($input['termo'] ?? '', FILTER_SANITIZE_STRING);
    // Removemos os argumentos extras que não são usados pelo VagaModel agora.
    $vagas = $model->buscarVagasReais($termo);
    echo json_encode($vagas);
    break;

  case 'perguntarIA':
    $pergunta = filter_var($input['pergunta'] ?? '', FILTER_SANITIZE_STRING);
    $resposta = $model->consultarIA($pergunta);
    echo json_encode(['resposta' => $resposta]);
    break;

  case 'test':
    echo json_encode(['status' => 'success', 'message' => 'API ONLINE - ZERO VAGAS FAKE']);
    break;

  default:
    echo json_encode(['error' => 'Ação não encontrada: ' . $action]);
    break;
}
