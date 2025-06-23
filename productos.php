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
      <li><i class="fa-solid fa-chart-line"></i> Dashboard</li>
      <li class="active"><i class="fa-solid fa-boxes-stacked"></i> Productos</li>
      <li><i class="fa-solid fa-cash-register"></i> Ventas</li>
      <li><i class="fa-solid fa-right-from-bracket"></i> Salir</li>
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
            <option value="1L">1L</option>
            <option value="1.5L">1.5L</option>
            <option value="2L">2L</option>
            <option value="2.5L">2.5L</option>
            <option value="3L">3L</option>
          </optgroup>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required>

        <button type="submit">Agregar</button>
      </form>
    </div>

    <!-- Tabla a la derecha -->
    <div class="tabla-col">
      <?php
      require 'vendor/autoload.php';
      use PhpOffice\PhpSpreadsheet\IOFactory;

      $archivoExcel = 'productos.xlsx';

      if (file_exists($archivoExcel)) {
          $documento = IOFactory::load($archivoExcel);
          $hoja = $documento->getActiveSheet();
          $filas = $hoja->toArray();

          echo "<h2>Inventario Actual</h2>";
          echo "<table>";
          echo "<thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>CC</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                  </tr>
                </thead><tbody>";

          for ($i = 1; $i < count($filas); $i++) {
              echo "<tr>";
              echo "<td>" . $i . "</td>";

              foreach ($filas[$i] as $celda) {
                  echo "<td>" . htmlspecialchars($celda) . "</td>";
              }

              echo "<td>
                      <form method='post' action='eliminar_producto.php' onsubmit='return confirm(\"¿Eliminar este producto?\")' style='display:inline;'>
                        <input type='hidden' name='fila' value='$i'>
                        <button type='submit' class='eliminar'>Borrar</button>
                      </form>

                      <form method='post' action='editar_producto.php' style='display:inline; margin-left:5px;'>
                        <input type='hidden' name='fila' value='$i'>
                        <button type='submit' class='editar'>Editar</button>
                      </form>
                    </td>";
              echo "</tr>";
          }

          echo "</tbody></table>";
      } else {
          echo "<p>No hay productos registrados aún.</p>";
      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="/js/scripts.js"></script>
</body>
</html>
