<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$archivoExcel = 'productos.xlsx';

// Paso 1: Validar que vengan los datos
$filaEliminar = isset($_POST['fila']) ? intval($_POST['fila']) : 0;
$categoria = $_POST['categoria'] ?? '';

if ($filaEliminar < 2 || empty($categoria)) {
    echo "<p>Error: Fila inválida ($filaEliminar) o categoría no especificada ($categoria).</p>";
    exit;
}

// Paso 2: Verificar que el archivo existe
if (!file_exists($archivoExcel)) {
    echo "<p>Error: No existe el archivo Excel.</p>";
    exit;
}

// Paso 3: Cargar el Excel y la hoja
$documento = IOFactory::load($archivoExcel);
$hoja = $documento->getSheetByName($categoria);

if (!$hoja) {
    echo "<p>Error: No se encontró la hoja '$categoria'.</p>";
    exit;
}

// Paso 4: Eliminar la fila
$hoja->removeRow($filaEliminar, 1);

// Paso 5: Guardar cambios
$writer = IOFactory::createWriter($documento, 'Xlsx');
$writer->save($archivoExcel);

// Paso 6: Redirigir de vuelta a productos.php
header("Location: productos.php?categoria=" . urlencode($categoria));
exit;

