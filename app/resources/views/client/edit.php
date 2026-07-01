<section id="form-cruds" class="d-flex flex-column">
    <div class="container px-4 px-lg-5 mb-4">
      <div class="pt-5 pb-2 d-flex justify-content-between align-items-end">
        <div>
          <h2 class="fw-bold">Detalle del cliente</h2>
          <p class="lead">
            Visualice o modifique la información del cliente
          </p>
        </div>
        <div class="text-end mb-2">
          <div class="d-inline-flex align-items-center gap-2 form-check form-switch fs-6 justify-content-end p-0 mb-1">
            <input class="form-check-input m-0 custom-switch-style" type="checkbox" name="estado" id="estado-toggle" disabled>
            <span id="estado-data" class="text-success fw-bold small"></span>
          </div>
          <p id="fecha-data" class="small text-secondary mb-0"></p>
        </div>
      </div>

      <div class="card rounded-3 shadow-sm border-light">
        <div class="card-body p-4">
          <form
            id="form-edit"
            action="client/index"
            method="POST"
            autocomplete="off">
            <div class="d-flex flex-wrap gap-3">
              
              <div class="flex-grow-1 full-input">
                <label for="nombre-data" class="form-label fw-semibold">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  name="nombre"
                  id="nombre-data"
                  pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9. ]+$"
                  title="El nombre puede contener letras, números, puntos y espacios."
                  disabled
                  required />
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="tipo-data" class="form-label fw-semibold">Tipo</label>
                <select class="form-select" id="tipo-data" name="tipo" disabled required>
                  <option value="Particular">Particular</option>
                  <option value="Empresa">Empresa</option>
                </select>
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="dni-data" class="form-label fw-semibold">DNI</label>
                <input
                  type="text"
                  class="form-control"
                  id="dni-data"
                  name="dni"
                  inputmode="numeric"
                  pattern="^[0-9]{7,9}$"
                  maxlength="9"
                  minlength="7"
                  disabled />
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="razon-data" class="form-label fw-semibold">Razón social</label>
                <input
                  type="text"
                  class="form-control"
                  id="razon-data"
                  name="razon"
                  maxlength="150"
                  disabled />
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="cuit-data" class="form-label fw-semibold">CUIT / CUIL</label>
                <input
                  type="text"
                  class="form-control"
                  id="cuit-data"
                  name="cuit"
                  inputmode="numeric"
                  pattern="^[0-9]{11}$"
                  maxlength="11"
                  title="El CUIT debe contener 11 dígitos numéricos seguidos, sin guiones."
                  disabled />
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="telefono-data" class="form-label fw-semibold">Teléfono</label>
                <input
                  type="text"
                  class="form-control"
                  id="telefono-data"
                  name="telefono"
                  inputmode="numeric"
                  pattern="^[0-9 ]{7,20}$"
                  title="El teléfono debe ser un número válido."
                  disabled />
                
                <input type="hidden" id="client-id" name="id">
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="email-data" class="form-label fw-semibold">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email-data"
                  name="email"
                  maxlength="100"
                  disabled />
              </div>
            </div>

            <hr class="my-4 text-secondary opacity-25" />

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
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
                  href="client/index"
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