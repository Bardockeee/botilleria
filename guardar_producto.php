<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$archivoExcel = 'productos.xlsx';

// Obtener datos del formulario
$nombre = $_POST['nombre'] ?? '';
$cc = $_POST['cc'] ?? '';
$cantidad = $_POST['cantidad'] ?? '';
$precio = $_POST['precio'] ?? '';

if ($nombre === '' || $cc === '' || $cantidad === '' || $precio === '') {
    die("Faltan datos del formulario.");
}

if (!file_exists($archivoExcel)) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Inventario");
    $sheet->fromArray(["Nombre", "CC", "Cantidad", "Precio"], NULL, "A1");
} else {
    $spreadsheet = IOFactory::load($archivoExcel);
    $sheet = $spreadsheet->getActiveSheet();
}

// Buscar la siguiente fila vacía
$fila = $sheet->getHighestRow() + 1;

// Guardar los datos
$sheet->setCellValue("A$fila", $nombre);
$sheet->setCellValue("B$fila", $cc);
$sheet->setCellValue("C$fila", $cantidad);
$sheet->setCellValue("D$fila", $precio);

// Guardar el archivo
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($archivoExcel);

// Mensaje y redirección
echo "<script>alert('Producto guardado exitosamente.'); window.location.href='productos.php';</script>";
