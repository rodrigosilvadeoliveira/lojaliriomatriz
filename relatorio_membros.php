<?php
//Autoload do composer
require __DIR__.'/vendor/autoload.php';

// Dependências do projeto
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'lojalirio';

// Estabelecer a conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

$sql = "SELECT * FROM membros";

$result = $conexao->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Defina o cabeçalho da tabela
$sheet->setCellValue('A1', 'id');
$sheet->setCellValue('B1', 'Nome');
$sheet->setCellValue('C1', 'Sobrenome');
$sheet->setCellValue('D1', 'Data Nascimento');
$sheet->setCellValue('E1', 'Membro Desde');
$sheet->setCellValue('F1', 'Telefone');
$sheet->setCellValue('G1', 'Email');
$sheet->setCellValue('H1', 'Voluntário');
$sheet->setCellValue('I1', 'Lider');
$sheet->setCellValue('J1', 'departamento1');
$sheet->setCellValue('K1', 'departamentodo2');
$sheet->setCellValue('L1', 'departamento3');
$sheet->setCellValue('M1', 'Status');

//Estilo da celula
$styles = [
    'font' => [
        'bold' => true,
        'color' => [
            'rgb' => ''
        ],
        'size' => 10,
        'name' => 'Caimbra'
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
        'endColor' => [
            'argb' => 'FFFFFFFF',
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    
];

//Define o estilo da Celula cabeçalho
$sheet->getStyle('A1:S1')->applyFromArray($styles);

// Preencha os valores da tabela
if ($result) {
    $row = 2;
    while ($row_data = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $row_data['id']);
    $sheet->setCellValue('B' . $row, $row_data['nome']);
    $sheet->setCellValue('C' . $row, $row_data['sobrenome']);
    $sheet->setCellValue('D' . $row, $row_data['nascimento']);
    $sheet->setCellValue('E' . $row, $row_data['data']);
    $sheet->setCellValue('F' . $row, $row_data['telefone']);
    $sheet->setCellValue('G' . $row, $row_data['email']);
    $sheet->setCellValue('H' . $row, $row_data['voluntario']);
    $sheet->setCellValue('I' . $row, $row_data['lider']);
    $sheet->setCellValue('J' . $row, $row_data['departamentoum']);
    $sheet->setCellValue('K' . $row, $row_data['departamentodois']);
    $sheet->setCellValue('L' . $row, $row_data['departamentotres']);
    $sheet->setCellValue('M' . $row, $row_data['status']);
    $row++;
}
}else {
    echo "Por favor, selecione as datas.";
}

// Defina o cabeçalho do arquivo para download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="estoque_completo.xlsx"');
header('Cache-Control: max-age=0');

// Crie um objeto Writer para salvar o arquivo Excel
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Encerre a conexão com o banco de dados
$conexao->close();
