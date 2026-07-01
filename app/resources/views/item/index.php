  <section id="form-cruds" class="d-flex flex-column pb-5">
    <div class="container px-4 px-lg-5">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Gestión de Productos</h2>
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

            <div class="col-md-5">
              <label class="form-label small fw-bold">Buscar producto</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" id="filtro-buscar-producto" class="form-control" placeholder="Nombre o código...">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label small fw-bold">Categoría</label>
              <select id="filtro-categoria-producto" class="form-select">
                <option value="">Todas las categorías</option>
                <option value="1">Interior</option>
                <option value="2">Exterior</option>
                <option value="3">Sombra</option>
              </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
              <button type="button" id="btn-filtrar-productos" class="btn btn-primary w-50">
                Aplicar
              </button>
              <button type="button" id="btn-limpiar-productos" class="btn btn-outline-secondary w-50" title="Limpiar filtros">
                <i class="bi bi-arrow-clockwise me-1"></i>
              </button>
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
                <th scope="col">NOMBRE</th>
                <th scope="col">CÓDIGO</th>
                <th scope="col">RIEGO</th>
                <th scope="col">DESCRIPCIÓN</th>
                <th scope="col">CATEGORÍA</th>
                <th scope="col">PRECIO</th>
                <th scope="col">STOCK</th>
                <th scope="col">OPCIONES</th>
              </tr>
            </thead>
            <tbody id="item-table-body">
            </tbody>
          </table>
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 border-top bg-light">
            <div id="txt-mostrando-paginas" class="small text-secondary mb-2 mb-md-0">
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
            href="item/create"
            class="btn btn-outline-success btn-sm px-4">
            <i class="bi bi-plus-circle me-2"></i>Nuevo producto
          </a>
          <button
            class="btn btn-outline-secondary btn-sm btnExportarListado">
            Exportar listado
          </button>
        </div>
      </div>
    </div>
  </section>