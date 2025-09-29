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
    $termo = $input['termo'] ?? '';
    $arg2 = $input['arg2'] ?? null; // Replace with appropriate default or input
    $arg3 = $input['arg3'] ?? null; // Replace with appropriate default or input
    $arg4 = $input['arg4'] ?? null; // Replace with appropriate default or input
    $arg5 = $input['arg5'] ?? null; // Replace with appropriate default or input
    $vagas = $model->buscarVagasReais($termo, $arg2, $arg3, $arg4, $arg5);
    echo json_encode($vagas);
    break;

  case 'perguntarIA':
    $pergunta = $input['pergunta'] ?? '';
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
