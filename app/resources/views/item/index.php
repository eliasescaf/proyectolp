<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <base href="http://localhost/lab_prog_2026_escalante_fuentes_elias/" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="public/app/assets/libs/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="public/app/css/main.css" />
  <link rel="stylesheet" href="public/app/assets/libs/bootstrap/css/bootstrap-icons.css" />
  <script src="public/app/assets/libs/bootstrap/js/bootstrap.bundle.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js" defer></script>
  <script type="module" src="public/app/js/item/index.js" defer></script>
  <title>Plantín - Gestión de productos</title>
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
            <a
              class="nav-link active"
              href="app/resources/views/item/index.php"><i class="bi bi-box-seam"></i> Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app/resources/views/sale/index.php"><i class="bi bi-cart3"></i> Ventas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="app/resources/views/user/index.php"><i class="bi bi-people"></i> Usuarios</a>
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
              Productos
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <section id="form-cruds" class="d-flex flex-column pb-5">
    <div class="container px-4 px-lg-5">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Gestión de productos</h2>
        <p class="lead">Gestione todos sus productos</p>
      </div>

      <div class="d-flex justify-content-between align-items-center bg-white border rounded-3 px-3 py-2 mb-2 shadow-sm">
        <span class="text-secondary fw-bold small"><i class="bi bi-funnel me-2"></i>Filtros</span>
        <button class="btn btn-link btn-sm text-decoration-none text-muted" type="button" data-bs-toggle="collapse"
          data-bs-target="#collapseFiltros">
          <i class="bi bi-chevron-down"></i> <small>Configurar</small>
        </button>
      </div>

      <div class="collapse mb-3" id="collapseFiltros">
        <div class="card card-body shadow-sm border-light">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label small fw-bold">Buscar</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Nombre o código...">
              </div>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-bold">Categoría</label>
              <select class="form-select">
                <option selected>Todas</option>
                <option value="1">Interior</option>
                <option value="2">Exterior</option>
                <option value="2">Sombra</option>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-bold">Ordenar por</label>
              <select class="form-select">
                <option value="nombre">Nombre (A-Z)</option>
                <option value="cuenta">Nombre (Z-A)</option>
              </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
              <button class="btn btn-primary w-100">Aplicar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="card rounded-3 overflow-hidden shadow-sm border-light">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h5 class="mb-0 fw-bold">Lista de plantas</h5>
        </div>
        <div class="card-body p-0">
          <table id="item-table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Código</th>
                <th scope="col">Riego</th>
                <th scope="col">Descripción</th>
                <th scope="col">Categoría</th>
                <th scope="col">Precio</th>
                <th scope="col">Stock</th>
                <th scope="col">Opciones</th>
              </tr>
            </thead>
            <tbody id="item-table-body">
            </tbody>
          </table>
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 border-top bg-light">
            <div class="small text-secondary mb-2 mb-md-0">
              Mostrando <span class="fw-bold">1</span> a <span class="fw-bold">10</span> de <span class="fw-bold">100</span>
              usuarios
            </div>

            <nav>
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                  <a class="page-link text-success" href="#">Anterior</a>
                </li>
                <li class="page-item active">
                  <a class="page-link bg-success border-success" href="app/resources/views/user/index.php">1</a>
                </li>
                <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
                <li class="page-item"><a class="page-link text-success" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link text-success" href="#">Siguiente</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <div
          class="card-footer d-flex justify-content-between align-items-center">
          <a
            href="app/resources/views/item/create.php"
            class="btn btn-outline-success btn-sm px-4">
            <i class="bi bi-plus-circle me-2"></i>Nuevo producto
          </a>
          <btn
            class="btn btn-outline-secondary btn-sm btnExportarListado">
            Exportar listado
          </btn>
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