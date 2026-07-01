<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a id="marca-nombre" class="navbar-brand" href="home/index">
      <i class="bi bi-tree me-2"></i>Plantín
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="home/index"><i class="bi bi-house-door"></i> Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="item/index"><i class="bi bi-box-seam"></i> Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sale/index"><i class="bi bi-cart3"></i> Ventas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="client/index"><i class="bi bi-person-vcard"></i> Clientes</a>
        </li>
        <?php if(isset($_SESSION['perfil']) && $_SESSION['perfil'] === 2){ ?>
        <li class="nav-item">
          <a class="nav-link" href="user/index"><i class="bi bi-people"></i> Usuarios</a>
        </li>
        <?php } ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i> Mi cuenta
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="account/index">Mis datos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id="btn-logout" class="dropdown-item text-danger" href="#">Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>