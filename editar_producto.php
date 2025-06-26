<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$archivoExcel = 'productos.xlsx';
$categoria = $_POST['categoria'] ?? '';
$fila = (int)($_POST['fila'] ?? 0);

if ($categoria === '' || $fila <= 1) {
    die("Categoría inválida o no se puede editar la cabecera.");
}

$documento = IOFactory::load($archivoExcel);
$hoja = $documento->getSheetByName($categoria);

if (!$hoja) {
    die("No se encontró la hoja de categoría.");
}

$datosFila = $hoja->rangeToArray("A$fila:E$fila")[0];
list($nombre, $cc, $cantidad, $tipo) = $datosFila;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
  <div class="formulario-editar">
    <h2>Editar producto - <?= htmlspecialchars($categoria) ?></h2>
    <form action="guardar_edicion.php" method="post">
      <input type="hidden" name="fila" value="<?= $fila ?>">
      <input type="hidden" name="categoria_original" value="<?= htmlspecialchars($categoria) ?>">

      <label>Nombre:</label>
      <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>

      <label>Tamaño (CC / Litros / Unidades):</label>
      <select name="cc" required>
        <optgroup label="Mililitros">
          <option value="330cc" <?= $cc == '330cc' ? 'selected' : '' ?>>330cc</option>
          <option value="470cc" <?= $cc == '470cc' ? 'selected' : '' ?>>470cc</option>
          <option value="710cc" <?= $cc == '710cc' ? 'selected' : '' ?>>710cc</option>
        </optgroup>
        <optgroup label="Litros">
          <option value="500ml" <?= $cc == '500ml' ? 'selected' : '' ?>>500ml</option>
          <option value="700ml" <?= $cc == '700ml' ? 'selected' : '' ?>>700ml</option>
          <option value="750ml" <?= $cc == '750ml' ? 'selected' : '' ?>>750ml</option>
          <option value="1L" <?= $cc == '1L' ? 'selected' : '' ?>>1L</option>
          <option value="1.5L" <?= $cc == '1.5L' ? 'selected' : '' ?>>1.5L</option>
          <option value="2L" <?= $cc == '2L' ? 'selected' : '' ?>>2L</option>
          <option value="2.5L" <?= $cc == '2.5L' ? 'selected' : '' ?>>2.5L</option>
          <option value="3L" <?= $cc == '3L' ? 'selected' : '' ?>>3L</option>
        </optgroup>
        <optgroup label="Cant. Cigarros">
          <option value="10" <?= $cc == '10' ? 'selected' : '' ?>>10</option>
          <option value="20" <?= $cc == '20' ? 'selected' : '' ?>>20</option>
        </optgroup>
      </select>

      <label>Cantidad:</label>
      <input type="number" name="cantidad" value="<?= htmlspecialchars($cantidad) ?>" required>

      <label>Tipo:</label>
      <select name="tipo" required>
        <option value="caja" <?= $tipo === 'caja' ? 'selected' : '' ?>>Caja</option>
        <option value="botella" <?= $tipo === 'botella' ? 'selected' : '' ?>>Botella</option>
        <option value="lata" <?= $tipo === 'lata' ? 'selected' : '' ?>>Lata</option>
        <option value="petaca" <?= $tipo === 'petaca' ? 'selected' : '' ?>>Petaca</option>
      </select>

      <label>Categoría:</label>
      <select name="categoria" required>
        <option value="Cerveza" <?= $categoria === 'Cerveza' ? 'selected' : '' ?>>Cerveza</option>
        <option value="Vinos" <?= $categoria === 'Vinos' ? 'selected' : '' ?>>Vinos</option>
        <option value="Cigarros" <?= $categoria === 'Cigarros' ? 'selected' : '' ?>>Cigarros</option>
        <option value="Abarrotes" <?= $categoria === 'Abarrotes' ? 'selected' : '' ?>>Abarrotes</option>
        <option value="Destilados" <?= $categoria === 'Destilados' ? 'selected' : '' ?>>Destilados</option>
        <option value="Bebidas" <?= $categoria === 'Bebidas' ? 'selected' : '' ?>>Bebidas</option>
      </select>

      <button type="submit">Guardar Cambios</button>
    </form>
  </div>
</body>
</html>