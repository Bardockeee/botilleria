<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$archivoExcel = 'productos.xlsx';

// Obtener datos del formulario
$nombre = $_POST['nombre'] ?? '';
$cc = $_POST['cc'] ?? '';
$cantidad = $_POST['cantidad'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$pagina = $_POST['pagina'] ?? 1;

if ($nombre === '' || $cc === '' || $cantidad === '' || $tipo === '' || $categoria === '') {
    die("Faltan datos del formulario.");
}

// Cargar o crear archivo
if (!file_exists($archivoExcel)) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle($categoria);
    $sheet->fromArray(["Nombre", "CC", "Cantidad", "Tipo"], NULL, "A1");
} else {
    $spreadsheet = IOFactory::load($archivoExcel);

    // Buscar o crear hoja según categoría
    $sheet = $spreadsheet->getSheetByName($categoria);
    if (!$sheet) {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle($categoria);
        $sheet->fromArray(["Nombre", "CC", "Cantidad", "Tipo"], NULL, "A1");
    }
}

// Buscar la siguiente fila vacía en esa hoja
$fila = $sheet->getHighestRow() + 1;

// Insertar los datos
$sheet->setCellValue("A$fila", $nombre);
$sheet->setCellValue("B$fila", $cc);
$sheet->setCellValue("C$fila", $cantidad);
$sheet->setCellValue("D$fila", $tipo);

// Guardar archivo
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($archivoExcel);

// Redirigir de vuelta a productos con categoría seleccionada
header("Location: productos.php?categoria=" . urlencode($categoria) . "&pagina=" . urlencode($pagina));
exit;