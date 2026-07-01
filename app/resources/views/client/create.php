<section id="form-cruds" class="d-flex flex-column">
    <div class="container px-4 px-lg-5 mb-4">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Nuevo cliente</h2>
        <p class="lead">Complete los datos para añadir un nuevo cliente</p>
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
                  
                  required />
              </div>
              
              <div class="flex-grow-1 mid-input">
                <label for="tipo-data" class="form-label fw-semibold">Tipo</label>
                <select class="form-select" id="tipo-data" name="tipo" required>
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
                  placeholder="Ej: 12345678"
                  pattern="^[0-9]{7,9}$"
                  maxlength="9"
                  minlength="7"
                   />
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="razon-data" class="form-label fw-semibold">Razón social</label>
                <input
                  type="text"
                  class="form-control"
                  id="razon-data"
                  name="razon"
                  placeholder="Ej: Vivero San Cayetano"
                  maxlength="150"
                   />
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="cuit-data" class="form-label fw-semibold">CUIT / CUIL</label>
                <input
                  type="text"
                  class="form-control"
                  id="cuit-data"
                  name="cuit"
                  inputmode="numeric"
                  placeholder="Ej: 20123456789"
                  pattern="^[0-9]{11}$"
                  maxlength="11"
                  title="El CUIT debe contener 11 dígitos numéricos seguidos, sin guiones."
                   />
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
                  placeholder="Ej: 2974123456"
                  title="El teléfono debe ser un número válido."
                   />
                
              </div>

              <div class="flex-grow-1 mid-input">
                <label for="email-data" class="form-label fw-semibold">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email-data"
                  name="email"
                  placeholder="Ej: cliente@correo.com"
                  maxlength="100"
                   />
              </div>
            </div>

            <hr class="my-4 text-secondary opacity-25" />
            <div class="d-flex justify-content-end gap-2">
              <a
                href="client/index"
                class="btn btn-light px-4">
                Regresar
              </a>
              <button type="submit" class="btn btn-success px-4 btnGuardar">
                Guardar y validar cliente
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>