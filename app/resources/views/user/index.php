  <section id="form-cruds" class="d-flex flex-column pb-5">
    <div class="container px-4 px-lg-5">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Gestión de Usuarios</h2>
        <p class="lead">Gestione las cuentas de sus usuarios</p>
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
                <input type="text" class="form-control" placeholder="Nombre, cuenta o correo...">
              </div>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-bold">Perfil</label>
              <select class="form-select">
                <option selected>Todos</option>
                <option value="1">Operador</option>
                <option value="2">Administrador</option>
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
          <h5 class="mb-0 fw-bold">Lista de usuarios</h5>
        </div>
        <div class="card-body p-0">
          <table id="user-table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">NOMBRE COMPLETO</th>
                <th scope="col">CUENTA</th>
                <th scope="col">PERFIL</th>
                <th scope="col">CORREO</th>
                <th scope="col">OPCIONES</th>
              </tr>
            </thead>
            <tbody id="user-table-body">
            </tbody>
          </table>
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 border-top bg-light">
            <div id="txt-mostrando-paginas" class="small text-secondary mb-2 mb-md-0">
              Cargando páginas...
            </div>

            <nav>
              <ul id="ul-paginacion" class="pagination pagination-sm mb-0">
              </ul>
            </nav>
          </div>
          <div
            class="card-footer d-flex justify-content-between align-items-center">
            <a
              href="user/create"
              class="btn btn-outline-success btn-sm px-4">
              <i class="bi bi-person-plus-fill me-2"></i>Nuevo usuario
            </a>
            <button
              class="btn btn-outline-secondary btn-sm btnExportarListado">
              Exportar listado
            </button>
          </div>
        </div>
      </div>
  </section>
  