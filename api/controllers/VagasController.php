<?php
require_once '../models/VagaModel.php';

class VagasController
{
  private $model;

  public function __construct()
  {
    $this->model = new VagaModel();
  }

  public function buscarVagas()
  {
    $input = json_decode(file_get_contents('php://input'), true);

    $termo = $input['termo'] ?? '';
    $cidade = $input['cidade'] ?? 'Montenegro';
    $estado = $input['estado'] ?? 'RS';
    $tipo = $input['tipo'] ?? '';
    $experiencia = $input['experiencia'] ?? '';

    // Buscar vagas reais de APIs públicas + fallback
    $vagas = $this->model->buscarVagasReais($termo, $cidade, $estado, $tipo, $experiencia);

    echo json_encode($vagas);
  }

  public function perguntarIA()
  {
    $input = json_decode(file_get_contents('php://input'), true);
    $pergunta = $input['pergunta'] ?? '';

    $resposta = $this->model->consultarIA($pergunta);

    echo json_encode(['resposta' => $resposta]);
  }
}
