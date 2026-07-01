  <section id="form-cruds" class="d-flex flex-column pb-5">
    <div class="container px-4 px-lg-5">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Gestión de Clientes</h2>
        <p class="lead">Gestione a todos sus clientes</p>
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

            <div class="col-md-5">
              <label class="form-label small fw-bold">Buscar</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Nombre, DNI o CUIT..." id="filtro-buscar">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-bold">Tipo de cliente</label>
              <select id="filtro-tipo-cliente" class="form-select">
                <option value="">Todos los tipos</option>
                <option value="Particular">Particulares</option>
                <option value="Empresa">Empresas</option>
              </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
              <button type="button" id="btn-filtrar-clientes" class="btn btn-primary w-50">
                 Aplicar
              </button>
              <button type="button" id="btn-limpiar-clientes" class="btn btn-outline-secondary w-50" title="Limpiar filtros">
                <i class="bi bi-arrow-clockwise me-1"></i>
              </button>
            </div>

          </div>
        </div>
      </div>
      <div class="card rounded-3 overflow-hidden shadow-sm border-light">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h5 class="mb-0 fw-bold">Lista de clientes</h5>
        </div>
        <div class="card-body p-0">
          <table id="client-table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">NOMBRE</th>
                <th scope="col">DNI</th>
                <th scope="col">RAZON</th>
                <th scope="col">CUIT</th>
                <th scope="col">TELEFONO</th>
                <th scope="col">CORREO</th>
                <th scope="col">OPCIONES</th>
              </tr>
            </thead>
            <tbody id="client-table-body">
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
        </div>
        <div
          class="card-footer d-flex justify-content-between align-items-center">
          <a
            href="client/create"
            class="btn btn-outline-success btn-sm px-4">
            <i class="bi bi-plus-circle me-2"></i>Nuevo cliente
          </a>
          <button
            class="btn btn-outline-secondary btn-sm btnExportarListado">
            Exportar listado
          </button>
        </div>
      </div>
    </div>
  </section>