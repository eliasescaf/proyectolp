<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <base href="http://localhost/lab_prog_2026_escalante_fuentes_elias/" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="public/app/css/bootstrap.min.css" />
  <link rel="stylesheet" href="public/app/css/main.css" />
  <link rel="stylesheet" href="public/app/css/bootstrap-icons.css" />
  <script src="public/app/js/bootstrap.bundle.min.js" defer></script>
  <script type="module" src="public/app/js/sale/create.js"></script>
  <title>Plantín - Gestión de ventas</title>
</head>

<body class="d-flex flex-column vh-100">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a
        id="marca-nombre"
        class="navbar-brand"
        href="app/resources/views/home/index.php"><i class="bi bi-tree me-2"></i>Plantín</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="app/resources/views/home/index.php"><i class="bi bi-house-door"></i> Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app/resources/views/item/index.php"><i class="bi bi-box-seam"></i> Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="app/resources/views/sale/index.php"><i class="bi bi-cart3"></i> Ventas</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link "
              href="app/resources/views/user/index.php"><i class="bi bi-people"></i> Usuarios</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i> Mi cuenta
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Mis datos</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="app/resources/views/authentication/index.php">Cerrar sesión</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div id="breadcrumb" class="border-top border-white border-opacity-10 py-2 mb-2">
    <div class="container px-4 px-lg-5">
      <nav aria-label="breadcrumb">
        <ol id="ol-breadcrumb" class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="app/resources/views/home/index.php" class="text-white-50 text-decoration-none link-light">
              Inicio
            </a>
          </li>
          <li class="breadcrumb-item">
            <a href="app/resources/views/sale/index.php" class="text-white-50 text-decoration-none link-light">
            Ventas
            </a>
          </li>
          <li class="breadcrumb-item active text-white fw-medium">
            Nueva venta
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <section id="form-cruds" class="container px-4 px-lg-5 py-4 flex-grow-1">
    <div class="mb-4">
      <h2 class="fw-bold">Registrar Nueva Venta</h2>
      <p class="lead text-secondary">Complete los datos del vendedor y cargue los productos al detalle.</p>
    </div>

    <div class="row g-4">

      <div class="col-md-5">
        <div class="card rounded-3 shadow-sm border-light h-100">
          <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-success">Cargar Artículos</h5>
          </div>
          <div class="card-body">

            <div class="mb-4">
              <label class="form-label small fw-bold">Vendedor</label>
              <select id="select-usuario" class="form-select">
                <option value="" selected disabled>Seleccione el vendedor...</option>
                <option value="1">Elias Escalante Fuentes</option>
                <option value="2">Admin</option>
              </select>
            </div>

            <hr class="text-muted my-3">

            <div class="mb-3">
              <label class="form-label small fw-bold">Seleccionar Producto</label>
              <select id="select-producto" class="form-select">
                <option value="" selected disabled>Elija un artículo...</option>
                <option value="10" data-precio="5500.00" data-stock="15">Monstera Deliciosa (Stock: 15) - $5.500,00</option>
                <option value="12" data-precio="2500.00" data-stock="4">Lengua de Suegra (Stock: 4) - $2.500,00</option>
                <option value="15" data-precio="4200.00" data-stock="0">Ficus Benjamina (Stock: 0) - $4.200,00</option>
              </select>
            </div>

            <div class="row g-2 mb-4">
              <div class="col-sm-6">
                <label class="form-label small fw-bold">Cantidad</label>
                <input type="number" id="input-cantidad" class="form-control" min="1" value="1">
              </div>
              <div class="col-sm-6 text-end d-flex flex-column justify-content-end">
                <span class="text-secondary small d-block mb-1">Precio Unitario:</span>
                <h5 id="txt-precio-unitario" class="fw-bold text-dark">$0,00</h5>
              </div>
            </div>

            <button type="button" id="btn-agregar-carrito" class="btn btn-outline-success w-100">
              <i class="bi bi-cart-plus me-2"></i>Agregar al Detalle
            </button>

          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="card rounded-3 shadow-sm border-light h-100 d-flex flex-column">
          <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Detalle de la Transacción</h5>
          </div>

          <div class="card-body p-0 flex-grow-1">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small fw-bold">
                  <tr>
                    <th scope="col">Producto</th>
                    <th scope="col" class="text-center" style="width: 15%;">Cant.</th>
                    <th scope="col" class="text-end" style="width: 20%;">P. Unit.</th>
                    <th scope="col" class="text-end" style="width: 20%;">Subtotal</th>
                    <th scope="col" class="text-center" style="width: 10%;">Acción</th>
                  </tr>
                </thead>
                <tbody id="carrito-body">
                  <tr>
                    <td>Monstera Deliciosa</td>
                    <td class="text-center">2</td>
                    <td class="text-end">$5.500,00</td>
                    <td class="text-end fw-bold">$11.000,00</td>
                    <td class="text-center">
                      <button class="btn btn-link link-danger p-0 btnBorrarItem" data-index="0">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-footer bg-light p-3 border-top mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="fw-bold text-secondary">TOTAL FACTURADO:</span>
              <h3 id="txt-total-general" class="fw-bold text-success mb-0">$11.000,00</h3>
            </div>

            <div class="d-flex justify-content-between">
              <a href="app/resources/views/sale/index.php" class="btn btn-outline-secondary btn-sm px-3">
                Cancelar
              </a>
              <button type="button" id="btn-guardar-venta" class="btn btn-success btn-sm px-4">
                <i class="bi bi-check-circle me-2"></i>Confirmar Venta
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  <footer id="footer-home" class="py-3 mt-auto text-white">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-4 text-md-start">
          <p class="mb-0 fw-bold">Plantín - Versión(1.0.0)</p>
          <p class="small mb-0 text-secondary">
            Todos los derechos reservados - 2026@
          </p>
        </div>
        <div class="col-md-8 text-center text-md-end">
          <ul class="list-inline mb-0 small">
            <li class="list-inline-item text-white">
              Elias Escalante Fuentes
            </li>
            <li class="list-inline-item">|</li>
            <li class="list-inline-item">Lab. de Programación</li>
            <li class="list-inline-item">|</li>
            <li class="list-inline-item d-none d-lg-inline">
              Ing. en Sistemas
            </li>
            <li class="list-inline-item">|</li>
            <li class="list-inline-item">UNPA-UACO</li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>