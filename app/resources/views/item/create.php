  <section id="form-cruds" class="d-flex flex-column">
    <div class="container px-4 px-lg-5 mb-4">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Nuevo producto</h2>
        <p class="lead">Complete los datos para añadir un nuevo producto</p>
      </div>
      <div class="card rounded-3 shadow-sm border-light">
        <div class="card-body p-2">
          <form
            id="form-edit"
            class="p-2"
            autocomplete="off">
            <div class="d-flex flex-wrap gap-3">
              <div class="flex-grow-1 mid-input">
                <label for="nombre-data" class="form-label fw-semibold">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  id="nombre-data"
                  name="nombre"
                  minlength="2"
                  pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$"
                  title="Los nombres solo deben contener letras y espacios."
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
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="riego-data" class="form-label fw-semibold">Riego</label>
                <select
                  class="form-select"
                  name="riego"
                  id="riego-data"
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
                <label class="form-label fw-semibold" for="categoria-data">Categoría</label>
                <select
                  class="form-select"
                  name="categoria"
                  id="categoria-data"
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
                  required />
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
                  required></textarea>
              </div>
            </div>
            <hr class="my-4 text-secondary opacity-25" />
            <div class="d-flex justify-content-end gap-2">
              <a
                href="item/index"
                class="btn btn-light px-4">
                Regresar
              </a>
              <button type="submit" class="btn btn-success px-4 btnGuardar">
                Guardar y validar producto
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>