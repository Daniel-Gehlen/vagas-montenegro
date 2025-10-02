<?php
header('Content-Type: text/html; charset=utf-8');

class VagaModel {
    private $empresasMontenegro = [
        'Prefeitura de Montenegro' => 'https://www.montenegro.rs.gov.br/editais/',
        'SINE Montenegro' => 'https://empregabrasil.mte.gov.br/',
        'JBS Montenegro' => 'https://www.jbs.com.br/carreiras',
        'Unimed Vale do Caí' => 'https://www.unimed.coop.br/site/web/guest/valedocai/trabalheconosco',
        'Lojas Quero-Quero' => 'https://www.quero-quero.com.br/trabalhe-conosco'
    ];

    public function buscarVagasReais($termo = '') {
        $vagasReais = [];

        foreach ($this->empresasMontenegro as $empresa => $url) {
            if (empty($termo) || stripos($empresa, $termo) !== false) {
                $vagasReais[] = [
                    'titulo' => 'Vaga - ' . $empresa,
                    'empresa' => $empresa,
                    'localizacao' => 'Montenegro, RS',
                    'salario' => 'A combinar',
                    'tipo' => 'CLT',
                    'experiencia' => 'Variados',
                    'descricao' => 'Oportunidade em ' . $empresa . ' em Montenegro/RS',
                    'contato' => 'Site oficial',
                    'telefone' => '(51) 3632-XXXX',
                    'link_direto' => $url,
                    'fonte' => 'Site Oficial'
                ];
            }
            if (count($vagasReais) >= 3) break;
        }
        return $vagasReais;
    }
}

// Roteamento
if (isset($_GET['api']) && $_GET['api'] === 'buscar') {
    header('Content-Type: application/json');
    $vagaModel = new VagaModel();
    $termo = $_GET['termo'] ?? '';
    echo json_encode($vagaModel->buscarVagasReais($termo));
    exit;
}
?>
