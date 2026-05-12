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
    <title>Plantín - Gestión de productos</title>
  </head>
  <body class="d-flex flex-column vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <a
          id="marca-nombre"
          class="navbar-brand"
          href="app/resources/views/home/index.html"
          ><i class="bi bi-tree me-2"></i>Plantín</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="app/resources/views/home/index.html"
                ><i class="bi bi-house-door"></i> Inicio</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link active"
                href="app/resources/views/item/index.html"
                ><i class="bi bi-box-seam"></i> Productos</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="app/resources/views/sale/index.html"
                ><i class="bi bi-cart3"></i> Ventas</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="app/resources/views/user/index.html"
                ><i class="bi bi-people"></i> Usuarios</a
              >
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
                <li><a class="dropdown-item text-danger" href="#">Cerrar sesión</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
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
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col">Código</th>
                  <th scope="col">Descripción</th>
                  <th scope="col">Categoría</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Stock</th>
                  <th scope="col">Opciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Cactus</td>
                  <td>003</td>
                  <td>Planta de exterior e interior. Tamaños variables.</td>
                  <td>Sombra</td>
                  <td>4000</td>
                  <td>13</td>
                  <td>
                    <a
                      href="app/resources/views/item/edit.html"
                      class="btn btn-sm btn-outline-primary"
                      title="Editar"
                      ><i class="bi bi-pencil"></i
                    ></a>
                  </td>
                </tr>
                <tr>
                  <td>Sansevieria</td>
                  <td>001</td>
                  <td>Planta de interior. Tamaños similares.</td>
                  <td>Interior</td>
                  <td>12000</td>
                  <td>7</td>
                  <td>
                    <a
                      href="app/resources/views/item/edit.html"
                      class="btn btn-sm btn-outline-primary"
                      title="Editar"
                      ><i class="bi bi-pencil"></i
                    ></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div
            class="card-footer d-flex justify-content-between align-items-center"
          >
            <a
              href="app/resources/views/item/create.html"
              class="btn btn-outline-success btn-sm px-4"
            >
              Nuevo producto
            </a>
            <a
              href="javascript:void(0)"
              class="btn btn-outline-secondary btn-sm"
            >
              Exportar listado
            </a>
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
