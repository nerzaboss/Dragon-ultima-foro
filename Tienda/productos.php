<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos</title>
  <link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <header>
    <div class="menu logo-nav">
      <a href="index.html" class="logo">Dragon ultima</a>
      <label class="menu-icon"><span class="fas fa-bars icomin"></span></label>
      <nav class="navigation">
        <ul>
          <li><a href="nosotros.html">Nosotros</a></li>
          <li><a href="productos.html">Productos</a></li>
          <li><a href="contacto.html">Contacto</a></li>
          <li class="search-icon">
            <input type="search" placeholder="Search">
            <label class="icon">
              <span class="fas fa-search"></span>
            </label>
          </li>
          <li class="car">
            <svg class="bi bi-cart3" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
            </svg>
            <div id="carrito" class="dropdown-menu">
              <table id="lista-carrito" class="table">
                <thead>
                  <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              <a href="#" id="vaciar-carrito" class="button-vaciar">Vaciar Carrito</a>
              <a href="#" id="procesar-pedido" class="button-pedido">Procesar Compra</a>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class="modal" id="modal">
      <div class="modal-content">
        <img src="" alt="" class="modal-img" id="modal-img">
      </div>
      <div class="modal-boton" id="modal-boton">X</div>
    </div>

    <div class="container-productos" id="lista-productos">
      <?php
        // Conexión a la base de datos
        $conexion = new mysqli('localhost', 'usuario', 'contraseña', 'tienda');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta para obtener productos
        $query = "SELECT nombre, precio FROM productos";
        $resultado = $conexion->query($query);

        if ($resultado->num_rows > 0) {
            while ($producto = $resultado->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<img src='assets/img/dados.png' class='card-img'>";
                echo "<h5>" . htmlspecialchars($producto['nombre']) . "</h5>";
                echo "<p>Precio - <small class='precio'>" . number_format($producto['precio'], 2) . "</small></p>";
                echo "<a href='#' class='button agregar-carrito'>Comprar</a>";
                echo "</div>";
            }
        } else {
            echo "No hay productos disponibles.";
        }

        $conexion->close();
      ?>
    </div>
  </main>
</body>
</html>
