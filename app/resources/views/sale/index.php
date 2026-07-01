  <section id="form-cruds" class="d-flex flex-column pb-5">
    <div class="container px-4 px-lg-5">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Gestión de Ventas</h2>
        <p class="lead">Consulte el historial de transacciones y registre nuevas ventas</p>
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
              <label class="form-label small fw-bold">Buscar venta</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" id="filtro-buscar" class="form-control" placeholder="Vendedor...">
              </div>
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-bold">Desde la fecha</label>
              <input type="date" id="filtro-fecha-inicio" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label small fw-bold">Hasta la fecha</label>
              <input type="date" id="filtro-fecha-fin" class="form-control">
            </div>

            <div class="col-md-2 d-flex align-items-end gap-2">
              <button type="button" id="btn-aplicar-filtros" class="btn btn-primary w-50" title="Aplicar filtros">
                <i class="bi bi-funnel-fill"></i>
              </button>
              <button type="button" id="btn-limpiar-filtros" class="btn btn-outline-secondary w-50" title="Limpiar filtros">
                <i class="bi bi-arrow-clockwise"></i>
              </button>
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
                <th scope="col">NRO. VENTA</th>
                <th scope="col">FECHA Y HORA</th>
                <th scope="col">VENDEDOR</th>
                <th scope="col">TOTAL FACTURADO</th>
                <th scope="col" class="text-center">ACCIONES</th>
              </tr>
            </thead>
            <tbody id="sales-table-body">
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

          <div class="card-footer d-flex justify-content-between align-items-center bg-white">
            <a href="sale/create" class="btn btn-outline-success btn-sm px-4">
              <i class="bi bi-cart-plus me-2"></i>Nueva Venta
            </a>
            <button class="btn btn-outline-secondary btn-sm btnExportarListado">
              Exportar listado
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>