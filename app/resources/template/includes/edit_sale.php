<div class="modal fade" id="detalleVentaModal" tabindex="-1" aria-labelledby="detalleVentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="card modal-content rounded-3 border-light shadow-lg overflow-hidden">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
          <h5 class="modal-title fw-bold" id="detalleVentaModalLabel">
            <i class="bi bi-receipt text-success me-2"></i>Comprobante de Venta <span id="modal-nro-venta" class="text-muted">#00000</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          <div class="row g-3 mb-4 bg-light p-3 rounded-3 border border-light">
            <div class="col-sm-6">
              <span class="text-secondary small d-block">Registrado por:</span>
              <strong id="modal-operador" class="text-dark">Cargando...</strong>
            </div>
            <div class="col-sm-6 text-sm-end">
              <span class="text-secondary small d-block">Fecha y Hora:</span>
              <strong id="modal-fecha" class="text-dark">Cargando...</strong>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
              <thead class="table-light text-secondary small fw-bold">
                <tr>
                  <th scope="col">Producto / Planta</th>
                  <th scope="col" class="text-center" style="width: 15%;">Cantidad</th>
                  <th scope="col" class="text-end" style="width: 25%;">Precio Unitario</th>
                  <th scope="col" class="text-end" style="width: 25%;">Subtotal</th>
                </tr>
              </thead>
              <tbody id="modal-detalle-body">
              </tbody>
              <tfoot>
                <tr class="table-light-subtle border-bottom-0">
                  <td colspan="3" class="text-end fw-semibold text-secondary small py-2">Descuento aplicado:</td>
                  <td id="modal-descuento-venta" class="text-end fw-bold text-danger small py-2">$0,00</td>
                </tr>
                <tr class="table-light">
                  <td colspan="3" class="text-end fw-bold text-dark py-2">Monto Total:</td>
                  <td id="modal-total-venta" class="text-end fw-bold text-success fs-5 py-2">$0,00</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between align-items-center py-3 border-top">
          <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-danger btn-sm px-4 btnImprimirTicketModal">
            <i class="bi bi-file-earmark-pdf me-1"></i>Descargar Ticket PDF
          </button>
        </div>

      </div>
    </div>
  </div>