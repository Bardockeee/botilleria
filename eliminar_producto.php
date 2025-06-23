<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$archivoExcel = 'productos.xlsx';

if (isset($_POST['fila'])) {
    $fila = (int) $_POST['fila'];

    if (file_exists($archivoExcel)) {
        $spreadsheet = IOFactory::load($archivoExcel);
        $sheet = $spreadsheet->getActiveSheet();

        // Elimina la fila (+1 porque empieza en 1)
        $sheet->removeRow($fila + 1);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($archivoExcel);
    }
}

header("Location: productos.php");
exit;
