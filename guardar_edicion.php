<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$archivoExcel = 'productos.xlsx';

if (isset($_POST['fila'])) {
    $fila = (int) $_POST['fila'];
    $nombre = $_POST['nombre'];
    $cc = $_POST['cc'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $spreadsheet = IOFactory::load($archivoExcel);
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue("A" . ($fila + 1), $nombre);
    $sheet->setCellValue("B" . ($fila + 1), $cc);
    $sheet->setCellValue("C" . ($fila + 1), $cantidad);
    $sheet->setCellValue("D" . ($fila + 1), $precio);

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($archivoExcel);
}

header("Location: productos.php");
exit;
?>