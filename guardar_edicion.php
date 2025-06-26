<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$archivoExcel = 'productos.xlsx';

// Datos del formulario
$fila = intval($_POST['fila'] ?? 0);
$categoria_original = $_POST['categoria_original'] ?? '';
$categoria_nueva = $_POST['categoria'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$cc = $_POST['cc'] ?? '';
$cantidad = $_POST['cantidad'] ?? '';
$tipo = $_POST['tipo'] ?? '';

// Validación básica
if (!$fila || $categoria_original === '' || $categoria_nueva === '' || $nombre === '' || $cc === '' || $cantidad === '' || $tipo === '') {
    die("Faltan datos.");
}

// Abrir archivo
if (!file_exists($archivoExcel)) {
    die("Archivo Excel no encontrado.");
}
$spreadsheet = IOFactory::load($archivoExcel);

// Obtener hoja original
$hoja_origen = $spreadsheet->getSheetByName($categoria_original);
if (!$hoja_origen) {
    die("Hoja original no encontrada.");
}

// Si la categoría no cambió, solo actualizamos en la misma hoja
if ($categoria_original === $categoria_nueva) {
    $hoja_origen->setCellValue("A$fila", $nombre);
    $hoja_origen->setCellValue("B$fila", $cc);
    $hoja_origen->setCellValue("C$fila", $cantidad);
    $hoja_origen->setCellValue("D$fila", $tipo);
} else {
    // Eliminar fila de hoja original
    $hoja_origen->removeRow($fila);

    // Obtener o crear hoja nueva
    $hoja_nueva = $spreadsheet->getSheetByName($categoria_nueva);
    if (!$hoja_nueva) {
        $hoja_nueva = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $categoria_nueva);
        $spreadsheet->addSheet($hoja_nueva);
        $hoja_nueva->fromArray(["Nombre", "CC", "Cantidad", "Tipo"], NULL, "A1");
    }

    // Buscar siguiente fila vacía
    $nueva_fila = $hoja_nueva->getHighestRow() + 1;
    $hoja_nueva->setCellValue("A$nueva_fila", $nombre);
    $hoja_nueva->setCellValue("B$nueva_fila", $cc);
    $hoja_nueva->setCellValue("C$nueva_fila", $cantidad);
    $hoja_nueva->setCellValue("D$nueva_fila", $tipo);
}

// Guardar cambios
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($archivoExcel);

// Redirigir a nueva categoría
header("Location: productos.php?categoria=" . urlencode($categoria_nueva));
exit;