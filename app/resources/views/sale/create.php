  <section id="form-cruds" class="container px-4 px-lg-5 py-4 flex-grow-1">
    <div class="mb-4">
      <h2 class="fw-bold">Registrar Nueva Venta</h2>
      <p class="lead text-secondary">Complete los datos del vendedor y cargue los productos al detalle.</p>
    </div>

    <div class="row g-4">

      <div class="col-md-5">
        <div class="card rounded-3 shadow-sm border-light h-100">
          <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-success">Cargar Artículos</h5>
          </div>
          <div class="card-body">

            <div class="mb-2">
              <label class="form-label small fw-bold">Vendedor</label>
              <p class="form-control-plaintext fw-semibold text-dark mb-0">
                <?php echo $_SESSION['usuario']; ?>
              </p>
            </div>

            <div class="mb-2 position-relative">
              <label class="form-label small fw-bold">Cliente</label>
              <div class="input-group input-group-sm">
                <span class="input-group-text bg-white"><i class="bi bi-person-search"></i></span>
                <input
                  type="text"
                  id="input-sugestivo-cliente"
                  class="form-control form-control-sm"
                  placeholder="Escriba nombre, apellido o DNI..."
                  autocomplete="off">
              </div>

              <ul id="contenedor-sugerencias-cliente" class="dropdown-menu w-100 shadow-sm mt-1" style="max-height: 180px; overflow-y: auto;">
              </ul>

              <input type="hidden" id="cliente-id-seleccionado" value="">
            </div>

            <hr class="text-muted my-3">

            <div class="mb-3 position-relative">
              <label class="form-label small fw-bold">Buscar Producto</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input
                  type="text"
                  id="input-sugestivo-producto"
                  class="form-control"
                  placeholder="Escriba el nombre del artículo..."
                  autocomplete="off">
              </div>

              <ul id="contenedor-sugerencias" class="dropdown-menu w-100 shadow-sm mt-1" style="max-height: 200px; overflow-y: auto;">
              </ul>

              <input type="hidden" id="producto-id-seleccionado" value="">
            </div>

            <div class="row g-2 mb-4">
              <div class="col-sm-6">
                <label class="form-label small fw-bold">Cantidad</label>
                <input type="number" id="input-cantidad" class="form-control" min="1" value="1">
              </div>
              <div class="col-sm-6 text-end d-flex flex-column justify-content-end">
                <span class="text-secondary fw-bold small d-block mb-1">Precio Unitario:</span>
                <h5 id="txt-precio-unitario" class="fw-bold text-dark">$0,00</h5>
              </div>
            </div>

            <button type="button" id="btn-agregar-carrito" class="btn btn-outline-success w-100">
              <i class="bi bi-cart-plus me-2"></i>Agregar al Detalle
            </button>

          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="card rounded-3 shadow-sm border-light h-100 d-flex flex-column">
          <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Detalle de la Transacción</h5>
          </div>

          <div class="card-body p-0 flex-grow-1">
            
            <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small fw-bold carrito-detalle">
                  <tr>
                    <th scope="col">Producto</th>
                    <th scope="col" class="text-center" style="width: 22%;">Cant.</th>
                    <th scope="col" class="text-end" style="width: 20%;">P. Unit.</th>
                    <th scope="col" class="text-end" style="width: 20%;">Subtotal</th>
                    <th scope="col" class="text-center" style="width: 10%;">Acción</th>
                  </tr>
                </thead>
                <tbody id="carrito-body">
                </tbody>
              </table>
            </div>

          </div>

          <div class="card-footer bg-light p-3 border-top mt-auto">
            <div class="row align-items-end mb-3 g-3">

              <div class="col-sm-6">
                <div class="mb-2">
                  <label class="form-label small fw-bold text-secondary mb-1">Forma de Pago</label>
                  <select id="select-forma-pago" class="form-select form-select-sm fw-semibold text-dark" required>
                    <option value="" selected disabled>Seleccione método...</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Debito">Tarjeta de Débito</option>
                    <option value="Credito">Tarjeta de Crédito</option>
                    <option value="Transferencia">Transferencia / Alias</option>
                  </select>
                </div>

                <div class="form-check form-switch m-0 pt-1">
                  <input class="form-check-input custom-switch-style" type="checkbox" id="check-descuento" disabled>
                  <label class="form-check-label small fw-bold text-secondary" for="check-descuento" id="label-descuento">
                    Descuento - Efectivo (21%)
                  </label>
                </div>
              </div>

              <div class="col-sm-6 text-end">
                <div class="d-flex justify-content-end align-items-center gap-2 mb-1">
                  <span class="text-secondary fw-semibold small">Descuento:</span>
                  <span id="txt-descuento" class="fw-semibold text-danger small">$0,00</span>
                </div>
                <span class="fw-bold text-secondary small d-block mb-1">TOTAL FACTURADO:</span>
                <h3 id="txt-total-general" class="fw-bold text-success mb-0">$0,00</h3>
              </div>

            </div>

            <div class="d-flex justify-content-between border-top pt-3">
              <a href="sale/index" class="btn btn-outline-secondary btn-sm px-3">
                Cancelar
              </a>
              <button type="button" id="btn-guardar-venta" class="btn btn-success btn-sm px-4">
                <i class="bi bi-check-circle me-2"></i>Confirmar Venta
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>