  <section id="form-cruds" class="d-flex flex-column">
    <div class="container px-4 px-lg-5 mb-4">
      <div class="pt-5 pb-2 d-flex justify-content-between align-items-end">
        <div>
          <h2 class="fw-bold">Detalle del producto</h2>
          <p class="lead">
            Visualice o modifique la información del producto
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
            action="item/index"
            method="POST"
            autocomplete="off">
            <div class="d-flex flex-wrap gap-3">
              <div class="flex-grow-1 mid-input">
                <label for="nombre-data" class="form-label fw-semibold">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  name="nombre"
                  id="nombre-data"
                  pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$"
                  title="Los nombres solo deben contener letras y espacios."
                  disabled
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="codigo-data" class="form-label fw-semibold">Código</label>
                <input
                  type="text"
                  class="form-control"
                  id="codigo-data"
                  name="codigo"
                  placeholder="Ej: MONS-01"
                  maxlength="10"
                  disabled
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="riego-data" class="form-label fw-semibold">Riego</label>
                <select
                  class="form-select"
                  name="riego"
                  id="riego-data"
                  disabled
                  required>
                  <option value="" disabled selected>
                    Seleccione un nivel...
                  </option>
                  <option value="1">Bajo</option>
                  <option value="2">Medio</option>
                  <option value="3">Alto</option>
                </select>
              </div>
              <div class="flex-grow-1 mid-input">
                <label class="form-label" for="categoria-data">Categoria</label>
                <select
                  class="form-select"
                  name="categoria"
                  id="categoria-data"
                  disabled
                  required>
                  <option value="" disabled selected>
                    Seleccione una categoría...
                  </option>
                  <option value="1">Interior</option>
                  <option value="2">Exterior</option>
                  <option value="3">Sombra</option>
                </select>
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="precio-data" class="form-label fw-semibold">Precio</label>
                <input
                  type="number"
                  class="form-control"
                  id="precio-data"
                  name="precio"
                  min="0"
                  step="0.01"
                  title="El precio debe ser mayor a 0."
                  disabled
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="stock-data" class="form-label fw-semibold">Stock</label>
                <input
                  type="number"
                  class="form-control"
                  id="stock-data"
                  name="stock"
                  min="0"
                  step="1"
                  title="El stock debe ser mayor a 0."
                  disabled
                  required />
                <input type="hidden" id="item-id" name="id">
              </div>
              <div class="w-100 mt-2">
                <label for="descripcion-data" class="form-label fw-semibold">Descripción</label>
                <textarea
                  class="form-control"
                  id="descripcion-data"
                  name="descripcion"
                  rows="3"
                  maxlength="255"
                  placeholder="Escriba los detalles o características de la planta..."
                  title="Las descripciones tienen un largo máximo de 255 caracteres."
                  disabled
                  required></textarea>
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
                  href="item/index"
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