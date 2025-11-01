<?php
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registro de Producto</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <main class="container">
    <h1>Formulario de Productos</h1>
   <form id="productoForm" novalidate>

      <div class="fila">
        <div>
          <label for="codigo">Código</label>
          <input type="text" id="codigo" name="codigo"  />
          <span id="error-codigo" class="error"></span>
        </div>

        <div>
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre"  />
          <span id="error-nombre" class="error"></span>
        </div>
      </div>

      <div class="fila">
        <div>
          <label for="bodega">Bodega</label>
          <select id="bodega" name="bodega">
            <option value="">--</option>
          </select>
          <span id="error-bodega" class="error"></span>
        </div>

        <div>
          <label for="sucursal">Sucursal</label>
          <select id="sucursal" name="sucursal">
            <option value="">--</option>
          </select>
          <span id="error-sucursal" class="error"></span>
        </div>
      </div>

      <div class="fila">
        <div>
          <label for="moneda">Moneda</label>
          <select id="moneda" name="moneda">
            <option value="">--</option>
          </select>
          <span id="error-moneda" class="error"></span>
        </div>

        <div>
          <label for="precio">Precio</label>
          <input type="text" id="precio" name="precio" />
          <span id="error-precio" class="error"></span>
        </div>
      </div>

      <fieldset>
        <legend>Material del Producto</legend>
        <div id="materialesContainer">
          <label><input type="checkbox" name="materiales[]" value="plastico"> Plástico</label>
          <label><input type="checkbox" name="materiales[]" value="metal"> Metal</label>
          <label><input type="checkbox" name="materiales[]" value="madera"> Madera</label>
          <label><input type="checkbox" name="materiales[]" value="vidrio"> Vidrio</label>
          <label><input type="checkbox" name="materiales[]" value="textil"> Textil</label>
        </div>
        <span id="error-materiales" class="error"></span>
      </fieldset>

      <div>
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4"></textarea>
        <span id="error-descripcion" class="error"></span>
      </div>

      <button type="submit" id="guardarBtn" class="btn-guardar">Guardar Producto</button>
    </form>
    <div id="resultado" aria-live="polite"></div>
  </main>
  <script src="javascript/index.js"></script>
</body>
</html>
