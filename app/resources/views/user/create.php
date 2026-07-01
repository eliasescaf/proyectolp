  <section id="form-cruds" class="d-flex flex-column">
    <div class="container px-4 px-lg-5 mb-4">
      <div class="py-2 me-auto mt-3">
        <h2 class="fw-bold">Nuevo usuario</h2>
        <p class="lead">Complete los datos para añadir un nuevo integrante</p>
      </div>
      <div class="card rounded-3 shadow-sm border-light">
        <div class="card-body p-2">
          <form
            id="form-edit"
            action="app/resources/views/user/index.php"
            method="POST"
            class="p-2"
            autocomplete="off">
            <div class="d-flex flex-wrap gap-3">
              <div class="flex-grow-1 full-input">
                <label for="nombre-data" class="form-label fw-semibold">Nombre completo</label>
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
                <label for="cuenta-data" class="form-label fw-semibold">Cuenta</label>
                <input
                  type="text"
                  class="form-control"
                  id="cuenta-data"
                  name="cuenta"
                  pattern="^[a-zA-Z0-9]+$"
                  title="La cuenta no puede contener espacios."
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label class="form-label" for="perfil-data">Perfil</label>
                <select
                  class="form-select"
                  name="perfil"
                  id="perfil-data"
                  required>
                  <option value="1">Operador</option>
                  <option value="2">Administrador</option>
                </select>
              </div>
              <div class="flex-grow-1 full-input">
                <label for="email-data" class="form-label fw-semibold">Correo electrónico</label>
                <input
                  type="email"
                  class="form-control"
                  id="email-data"
                  name="correo"
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="contraseña-data" class="form-label fw-semibold">Contraseña</label>
                <input
                  type="password"
                  class="form-control"
                  id="contraseña-data"
                  name="contraseña"
                  minlength="8"
                  title="La contraseña debe tener al menos 8 caracteres."
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="contraseña2-data" class="form-label fw-semibold">Confirmar contraseña</label>
                <input
                  type="password"
                  class="form-control"
                  id="contraseña2-data"
                  name="contraseña2-data"
                  required />
              </div>
            </div>
            <hr class="my-4 text-secondary opacity-25" />
            <div class="d-flex justify-content-end gap-2">
              <a
                href="user/index"
                class="btn btn-light px-4">
                Regresar
              </a>
              <button type="submit" class="btn btn-success px-4 btnGuardar">
                Guardar y validar usuario
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>