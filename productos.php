<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Botillería</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>

  <div class="sidebar">
    <h2><i class="fa-solid fa-wine-bottle"></i> Botillería</h2>
    <ul>
      <a href="dashboard.html" class="sidebar-link"><li><i class="fa-solid fa-chart-line"></i> Dashboard</li></a>
      <a href="productos.php" class="sidebar-link active"><li><i class="fa-solid fa-boxes-stacked"></i> Productos</li></a>
      <a href="ventas.php" class="sidebar-link"><li><i class="fa-solid fa-cash-register"></i> Ventas</li></a>
      <a href="#" class="sidebar-link"><li><i class="fa-solid fa-right-from-bracket"></i> Salir</li></a>
    </ul>
  </div>

  <div class="contenido-productos">

    <!-- Formulario a la izquierda -->
    <div class="formulario-col">
      <form action="guardar_producto.php" method="post" class="formulario-producto">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="cc">Tamaño (CC / Litros):</label>
        <select id="cc" name="cc" required>
          <optgroup label="Mililitros">
            <option value="330cc">330cc</option>
            <option value="470cc">470cc</option>
            <option value="710cc">710cc</option>
          </optgroup>
          <optgroup label="Litros">
            <option value="200ml">200ml</option>
            <option value="250ml">250ml</option>
            <option value="225ml">225ml</option>
            <option value="275ml">275ml</option>
            <option value="296ml">296ml</option>
            <option value="300ml">300ml</option>
            <option value="350ml">350ml</option>
            <option value="355ml">355ml</option>
            <option value="478ml">473ml</option>
            <option value="500ml">500ml</option>
            <option value="591ml">591ml</option>
            <option value="600ml">600ml</option>
            <option value="620ml">620ml</option>
            <option value="650ml">650ml</option>
            <option value="700ml">700ml</option>
            <option value="750ml">750ml</option>
            <option value="900ml">900ml</option>
            <option value="1L">1L</option>
            <option value="1.1L">1.1L</option>
            <option value="1.5L">1.5L</option>
            <option value="2L">2L</option>
            <option value="2.5L">2.5L</option>
            <option value="3L">3L</option>
          </optgroup>
          <optgroup label="cant cigarros">
            <option value="10">10</option>
            <option value="20">20</option>
          </optgroup>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
          <optgroup label="tipo">
            <option value="caja">caja</option>
            <option value="botella">botella</option>
            <option value="lata">lata</option>
            <option value="petaca">petaca</option>
          </optgroup>
        </select>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
          <option value="Cerveza">Cerveza</option>
          <option value="Vinos">Vinos</option>
          <option value="Cigarros">Cigarros</option>
          <option value="Abarrotes">Abarrotes</option>
          <option value="Destilados">Destilados</option>
          <option value="Bebidas">Bebidas</option>
        </select>
        <input type="hidden" name="pagina" value="<?= htmlspecialchars($_GET['pagina'] ?? 1) ?>">
        <button type="submit">Agregar</button>
      </form>
    </div>

    <!-- Tabla a la derecha -->
    <div class="tabla-col">

      <!-- Selector de categoría -->
      <form method="get" style="margin-bottom: 20px;">
        <label for="ver_categoria" style="color: white;">Ver categoría:</label>
        <select name="categoria" id="ver_categoria" onchange="this.form.submit()">
          <option value="Cerveza" <?= ($_GET['categoria'] ?? '') == 'Cerveza' ? 'selected' : '' ?>>Cerveza</option>
          <option value="Vinos" <?= ($_GET['categoria'] ?? '') == 'Vinos' ? 'selected' : '' ?>>Vinos</option>
          <option value="Cigarros" <?= ($_GET['categoria'] ?? '') == 'Cigarros' ? 'selected' : '' ?>>Cigarros</option>
          <option value="Abarrotes" <?= ($_GET['categoria'] ?? '') == 'Abarrotes' ? 'selected' : '' ?>>Abarrotes</option>
          <option value="Destilados" <?= ($_GET['categoria'] ?? '') == 'Destilados' ? 'selected' : '' ?>>Destilados</option>
          <option value="Bebidas" <?= ($_GET['categoria'] ?? '') == 'Bebidas' ? 'selected' : '' ?>>Bebidas</option>
        </select>
      </form>

      <?php
      require 'vendor/autoload.php';
      use PhpOffice\PhpSpreadsheet\IOFactory;

      $archivoExcel = 'productos.xlsx';
      $categoria = $_GET['categoria'] ?? 'Cerveza';
      $pagina = $_GET['pagina'] ?? 1;
      $paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
      $productosPorPagina = 10;

      if (file_exists($archivoExcel)) {
          $documento = IOFactory::load($archivoExcel);
          $hoja = $documento->getSheetByName($categoria);

          if ($hoja) {
              $filas = $hoja->toArray();
              $totalProductos = count($filas) - 1; // Quitamos la cabecera
              $totalPaginas = ceil($totalProductos / $productosPorPagina);
              $inicio = ($paginaActual - 1) * $productosPorPagina + 1;
              $fin = min($inicio + $productosPorPagina - 1, $totalProductos);

              echo "<h2>Inventario Actual - $categoria</h2>";
              echo "<table>";
              echo "<thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>CC</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                      </tr>
                    </thead><tbody>";

              for ($i = $inicio; $i <= $fin; $i++) {
                  $filaExcel = $i + 1;
                  echo "<tr>";
                  echo "<td>$i</td>";

                  foreach ($filas[$i] as $celda) {
                      echo "<td>" . htmlspecialchars($celda) . "</td>";
                  }

                  echo "<td>
                          <form method='post' action='eliminar_producto.php' onsubmit='return confirm(\"¿Eliminar este producto?\")' style='display:inline;'>
                            <input type='hidden' name='fila' value='$filaExcel'>
                            <input type='hidden' name='categoria' value='" . htmlspecialchars($categoria) . "'>
                            <button type='submit' class='eliminar'>Borrar</button>
                          </form>

                          <form method='post' action='editar_producto.php' style='display:inline; margin-left:5px;'>
                            <input type='hidden' name='fila' value='$filaExcel'>
                            <input type='hidden' name='categoria' value='" . htmlspecialchars($categoria) . "'>
                            <button type='submit' class='editar'>Editar</button>
                          </form>
                        </td>";
                  echo "</tr>";
              }

              echo "</tbody></table>";

              // Navegación de páginas
              echo "<div class='paginacion'>";
              if ($paginaActual > 1) {
                  echo "<a href='?categoria=$categoria&pagina=" . ($paginaActual - 1) . "'>&laquo; Anterior</a> ";
              }

              for ($p = 1; $p <= $totalPaginas; $p++) {
                  if ($p == $paginaActual) {
                      echo "<strong>$p</strong> ";
                  } else {
                      echo "<a href='?categoria=$categoria&pagina=$p'>$p</a> ";
                  }
              }

              if ($paginaActual < $totalPaginas) {
                  echo "<a href='?categoria=$categoria&pagina=" . ($paginaActual + 1) . "'>Siguiente &raquo;</a>";
              }
              echo "</div>";
          } else {
              echo "<p>No existe la hoja '$categoria'.</p>";
          }
      } else {
          echo "<p>No hay productos registrados aún.</p>";
      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/scripts.js"></script>
</body>
</html>
