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
    defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js" defer></script>
  <script type="module" src="public/app/js/user/edit.js"></script>
  <title>Plantín - Gestión de usuarios</title>
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
            <a class="nav-link" href="app/resources/views/sale/index.php"><i class="bi bi-cart3"></i> Ventas</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link active"
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
            <a href="app/resources/views/user/index.php" class="text-white-50 text-decoration-none link-light">
              Usuarios
            </a>
          </li>
          <li class="breadcrumb-item active text-white fw-medium">
            Editar usuario
          </li>
        </ol>
      </nav>
    </div>
  </div>
  <section id="form-cruds" class="d-flex flex-column">
    <div class="container px-4 px-lg-5 mb-4">
      <div class="pt-5 pb-2 d-flex justify-content-between align-items-end">
        <div>
          <h2 class="fw-bold">Detalle del usuario</h2>
          <p class="lead">
            Visualice o modifique la información del integrante
          </p>
        </div>
        <div class="text-end mb-2">
          <h5 id="estado-data" class="text-success mb-1"></h5>
          <p id="fecha-data" class="small text-secondary mb-0"></p>
        </div>
      </div>

      <div class="card rounded-3 shadow-sm border-light">
        <div class="card-body p-4">
          <form id="form-edit" action="app/resources/views/user/index.php" method="POST" autocomplete="off">
            <div class="d-flex flex-wrap gap-3">
              <div id="input-nombre" class="flex-grow-1 full-input">
                <label for="nombre-data" class="form-label fw-semibold">Nombre completo</label>
                <input
                  type="text"
                  id="nombre-data"
                  name="nombre"
                  class="form-control"
                  minlength="2"
                  pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$"
                  title="Los apellidos solo deben contener letras y espacios."
                  disabled
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="cuenta-data" class="form-label fw-semibold">Cuenta</label>
                <input
                  type="text"
                  class="form-control"
                  id="cuenta-data"
                  name="cuenta"
                  pattern="^[a-zA-Z0-9]+$"
                  title="La cuenta no debe almacenar espacios."
                  disabled
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label class="form-label" for="perfil-data">Perfil</label>
                <select
                  class="form-select"
                  name="perfil"
                  id="perfil-data"
                  disabled
                  required>
                  <option value="" disabled>Seleccione un perfil...</option>
                  <option value="1" selected>Operador</option>
                  <option value="2">Administrador</option>
                </select>
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="email-data" class="form-label fw-semibold">Correo electrónico</label>
                <input
                  type="email"
                  class="form-control"
                  id="email-data"
                  name="correo"
                  disabled
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="contraseña-data" class="form-label fw-semibold">Contraseña</label>
                <input
                  type="password"
                  class="form-control"
                  id="contraseña-data"
                  name="contraseña"
                  minlength="8"
                  title="La contraseña debe tener al menos 8 caracteres."
                  disabled
                  required />
                <input type="hidden" id="user-id" name="id">
              </div>
            </div>

            <hr class="my-4 text-secondary opacity-25" />

            <div
              class="d-flex flex-wrap justify-content-between align-items-center gap-2">
              <div>
                <button
                  type="button"
                  class="btn btn-outline-danger btnEliminar">
                  Eliminar
                </button>
                <button type="button" class="btn btn-outline-secondary btnPDF">
                  Exportar PDF
                </button>
              </div>

              <div class="d-flex gap-2">
                <a
                  href="app/resources/views/user/index.php"
                  class="btn btn-light px-4">Regresar</a>

                <button type="button" class="btn btn-primary px-4 btnEditar">
                  Editar información
                </button>

                <button
                  type="submit"
                  class="btn btn-success px-4 btnActualizar"
                  disabled>
                  Actualizar
                </button>
                <button
                  type="reset"
                  class="btn btn-secondary px-4 btnCancelar"
                  disabled>
                  Cancelar
                </button>
              </div>
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