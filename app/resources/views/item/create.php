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
    <script
      type="text/javascript"
      src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
      defer
    ></script>
    <script type="text/javascript" src="public/app/js/main.js" defer></script>
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
    <section id="form-cruds" class="d-flex flex-column">
      <div class="container px-4 px-lg-5 mb-4">
        <div class="py-2 me-auto mt-3">
          <h2 class="fw-bold">Nuevo producto</h2>
          <p class="lead">Complete los datos para añadir un nuevo producto</p>
        </div>
        <div class="card rounded-3 shadow-sm border-light">
          <div class="card-body p-2">
            <form
              action="app/resources/views/item/index.html"
              method="POST"
              class="p-2"
              autocomplete="off"
            >
              <div class="d-flex flex-wrap gap-3">
                <div class="flex-grow-1 mid-input">
                  <label for="nombre-data" class="form-label fw-semibold"
                    >Nombre</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="nombre-data"
                    name="nombre-data"
                    minlength="2"
                    pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$"
                    title="Los nombres solo deben contener letras y espacios."
                    required
                  />
                </div>
                <div class="flex-grow-1 mid-input">
                  <label for="codigo-data" class="form-label fw-semibold"
                    >Código</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="codigo-data"
                    name="codigo-data"
                    required
                  />
                </div>
                <div class="flex-grow-1 mid-input">
                  <label for="descripcion-data" class="form-label fw-semibold"
                    >Descripción</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="descripcion-data"
                    name="descripcion-data"
                    maxlength="50"
                    title="Las descripciones tienen un largo máximo de 50 caracteres."
                    required
                  />
                </div>
                <div class="flex-grow-1 mid-input">
                  <label class="form-label" for="categoria-data"
                    >Categoría</label
                  >
                  <select
                    class="form-select"
                    name="categoria-data"
                    id="categoria-data"
                    required
                  >
                    <option value="" disabled selected>
                      Seleccione una categoría...
                    </option>
                    <option value="1">Interior</option>
                    <option value="2">Exterior</option>
                    <option value="3">Sombra</option>
                  </select>
                </div>
                <div class="flex-grow-1 mid-input">
                  <label for="precio-data" class="form-label fw-semibold"
                    >Precio</label
                  >
                  <input
                    type="number"
                    class="form-control"
                    id="precio-data"
                    name="precio-data"
                    min="0"
                    step="0.01"
                    title="El precio debe ser mayor a 0."
                    required
                  />
                </div>
                <div class="flex-grow-1 mid-input">
                  <label for="stock-data" class="form-label fw-semibold"
                    >Stock</label
                  >
                  <input
                    type="number"
                    class="form-control"
                    id="stock-data"
                    name="stock-data"
                    min="0"
                    step="1"
                    title="El stock debe ser mayor a 0."
                    required
                  />
                </div>
              </div>
              <hr class="my-4 text-secondary opacity-25" />
              <div class="d-flex justify-content-end gap-2">
                <a
                  href="app/resources/views/item/index.html"
                  class="btn btn-light px-4"
                >
                  Regresar
                </a>
                <button type="submit" class="btn btn-success px-4 btnGuardar">
                  Guardar y validar producto
                </button>
              </div>
            </form>
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
