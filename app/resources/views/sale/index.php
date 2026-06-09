<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <base href="http://localhost/lab_prog_2026_escalante_fuentes_elias/" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="public/app/css/bootstrap.min.css" />
  <link rel="stylesheet" href="public/app/css/main.css" />
  <link rel="stylesheet" href="public/app/css/bootstrap-icons.css" />
  <script src="public/app/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js" defer></script>
  <script type="module" src="public/app/js/sale/index.js"></script>
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
          <li class="breadcrumb-item active text-white fw-medium">
            Ventas
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <section id="form-cruds" class="d-flex flex-column pb-5">
    <div class="container px-4 px-lg-5">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Gestión de Ventas</h2>
        <p class="lead">Consulte el historial de transacciones y registre nuevas ventas</p>
      </div>

      <div class="d-flex justify-content-between align-items-center bg-white border rounded-3 px-3 py-2 mb-2 shadow-sm">
        <span class="text-secondary fw-bold small"><i class="bi bi-funnel me-2"></i>Filtros de búsqueda</span>
        <button class="btn btn-link btn-sm text-decoration-none text-muted" type="button" data-bs-toggle="collapse"
          data-bs-target="#collapseFiltros">
          <i class="bi bi-chevron-down"></i> <small>Configurar</small>
        </button>
      </div>

      <div class="collapse mb-3" id="collapseFiltros">
        <div class="card card-body shadow-sm border-light">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label small fw-bold">Buscar por usuario</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Nombre o cuenta del usuario...">
              </div>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-bold">Desde la fecha</label>
              <input type="date" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-bold">Hasta la fecha</label>
              <input type="date" class="form-control">
            </div>

            <div class="col-md-2 d-flex align-items-end">
              <button class="btn btn-primary w-100">Aplicar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="card rounded-3 overflow-hidden shadow-sm border-light">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h5 class="mb-0 fw-bold">Historial de Transacciones</h5>
        </div>
        <div class="card-body p-0">
          <table id="sales-table" class="table table-striped table-hover mb-0">
            <thead>
              <tr>
                <th scope="col">Nro. Venta</th>
                <th scope="col">Fecha y Hora</th>
                <th scope="col">Operador</th>
                <th scope="col">Total Facturado</th>
                <th scope="col" class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody id="sales-table-body">
              <tr>
                <th scope="row">#00001</th>
                <td>25/05/2026 14:32</td>
                <td>Elias Escalante Fuentes</td>
                <td class="fw-bold">$8.000,00</td>
                <td class="text-center">
                  <button class="btn btn-outline-primary btn-sm btnVerDetalle" data-id="1">
                    <i class="bi bi-eye"></i> Detalle
                  </button>
                  <button class="btn btn-outline-danger btn-sm btnComprobantePDF" data-id="1">
                    <i class="bi bi-file-earmark-pdf"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 border-top bg-light">
            <div class="small text-secondary mb-2 mb-md-0">
              Mostrando <span class="fw-bold">1</span> a <span class="fw-bold">1</span> de <span class="fw-bold">1</span> ventas registradas
            </div>

            <nav>
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                  <a class="page-link text-success" href="#">Anterior</a>
                </li>
                <li class="page-item active">
                  <a class="page-link bg-success border-success" href="#">1</a>
                </li>
                <li class="page-item disabled">
                  <a class="page-link text-success" href="#">Siguiente</a>
                </li>
              </ul>
            </nav>
          </div>

          <div class="card-footer d-flex justify-content-between align-items-center bg-white">
            <a href="app/resources/views/sale/create.php" class="btn btn-outline-success btn-sm px-4">
              <i class="bi bi-cart-plus me-2"></i>Nueva Venta
            </a>
            <button class="btn btn-outline-secondary btn-sm btnExportarHistorial">
              Exportar listado
            </button>
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
  <div class="modal fade" id="detalleVentaModal" tabindex="-1" aria-labelledby="detalleVentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="card modal-content rounded-3 border-light shadow-lg overflow-hidden">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
          <h5 class="modal-title fw-bold" id="detalleVentaModalLabel">
            <i class="bi bi-receipt text-success me-2"></i>Comprobante de Venta <span id="modal-nro-venta" class="text-muted">#00000</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <div class="row g-3 mb-4 bg-light p-3 rounded-3 border border-light">
            <div class="col-sm-6">
              <span class="text-secondary small d-block">Registrado por:</span>
              <strong id="modal-operador" class="text-dark">Cargando...</strong>
            </div>
            <div class="col-sm-6 text-sm-end">
              <span class="text-secondary small d-block">Fecha y Hora:</span>
              <strong id="modal-fecha" class="text-dark">Cargando...</strong>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
              <thead class="table-light text-secondary small fw-bold">
                <tr>
                  <th scope="col">Producto / Planta</th>
                  <th scope="col" class="text-center" style="width: 15%;">Cantidad</th>
                  <th scope="col" class="text-end" style="width: 25%;">Precio Unitario</th>
                  <th scope="col" class="text-end" style="width: 25%;">Subtotal</th>
                </tr>
              </thead>
              <tbody id="modal-detalle-body">
                <tr>
                  <td>Monstera Deliciosa</td>
                  <td class="text-center">1</td>
                  <td class="text-end">$5.500,00</td>
                  <td class="text-end fw-bold">$5.500,00</td>
                </tr>
                <tr>
                  <td>Lengua de Suegra</td>
                  <td class="text-center">1</td>
                  <td class="text-end">$2.500,00</td>
                  <td class="text-end fw-bold">$2.500,00</td>
                </tr>
              </tbody>
              <tfoot>
                <tr class="table-light">
                  <td colspan="3" class="text-end fw-bold text-secondary">Monto Total:</td>
                  <td id="modal-total-venta" class="text-end fw-bold text-success fs-5">$8.000,00</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between align-items-center py-3 border-top">
          <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-danger btn-sm px-4 btnImprimirTicketModal">
            <i class="bi bi-file-earmark-pdf me-1"></i>Descargar Ticket PDF
          </button>
        </div>

      </div>
    </div>
  </div>
</body>

</html>