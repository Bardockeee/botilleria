<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$archivoExcel = 'productos.xlsx';

if (!isset($_POST['fila'])) {
  header("Location: productos.php");
  exit;
}

$fila = (int) $_POST['fila'];

$spreadsheet = IOFactory::load($archivoExcel);
$sheet = $spreadsheet->getActiveSheet();
$datos = $sheet->rangeToArray("A" . ($fila + 1) . ":D" . ($fila + 1), NULL, TRUE, TRUE, TRUE)[($fila + 1)];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="editar-body">

  
  <form method="post" action="guardar_edicion.php" class="formulario-editar">
    <h2>Editar Producto</h2>
    <input type="hidden" name="fila" value="<?= $fila ?>">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($datos['A']) ?>" required>

    <label>CC:</label>
    <select name="cc" required>
    <optgroup label="Mililitros">
        <option value="330cc" <?= $datos['B'] == "330cc" ? "selected" : "" ?>>330cc</option>
        <option value="470cc" <?= $datos['B'] == "470cc" ? "selected" : "" ?>>470cc</option>
        <option value="710cc" <?= $datos['B'] == "710cc" ? "selected" : "" ?>>710cc</option>
    </optgroup>
    <optgroup label="Litros">
        <option value="1L" <?= $datos['B'] == "1L" ? "selected" : "" ?>>1L</option>
        <option value="1.5L" <?= $datos['B'] == "1.5L" ? "selected" : "" ?>>1.5L</option>
        <option value="2L" <?= $datos['B'] == "2L" ? "selected" : "" ?>>2L</option>
        <option value="2.5L" <?= $datos['B'] == "2.5L" ? "selected" : "" ?>>2.5L</option>
        <option value="3L" <?= $datos['B'] == "3L" ? "selected" : "" ?>>3L</option>
    </optgroup>
    </select>


    <label>Cantidad:</label>
    <input type="number" name="cantidad" value="<?= $datos['C'] ?>" required>

    <label>Precio:</label>
    <input type="number" name="precio" value="<?= $datos['D'] ?>" required>

    <button type="submit">Guardar Cambios</button>
  </form>
</body>
</html>
