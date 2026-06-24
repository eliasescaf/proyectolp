  <section id="form-cruds" class="d-flex flex-column">
    <div class="container px-4 px-lg-5 mb-4">
      <div class="pt-5 pb-2 d-flex justify-content-between align-items-end">
        <div>
          <h2 class="fw-bold">Mis datos</h2>
          <p class="lead">
            Visualice sus datos o modifique su contraseña
          </p>
        </div>
        <div class="text-end mb-2">
          <p id="fecha-data" class="small text-secondary mb-0"></p>
        </div>
      </div>

      <div class="card rounded-3 shadow-sm border-light">
        <div class="card-body p-4">
          <form id="form-edit" action="user/index" method="POST" autocomplete="off">
            <div class="d-flex flex-wrap gap-3">
              <div id="input-nombre" class="flex-grow-1 full-input">
                <label for="nombre-data" class="form-label fw-semibold">Nombre completo</label>
                <input
                  type="text"
                  id="nombre-data"
                  name="nombre"
                  class="form-control"
                  minlength="2"
                  pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$"
                  title="Los apellidos solo deben contener letras y espacios."
                  disabled
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
                  title="La cuenta no debe almacenar espacios."
                  disabled
                  required />
              </div>
              <div class="flex-grow-1 mid-input">
                <label class="form-label" for="perfil-data">Perfil</label>
                <select
                  class="form-select"
                  name="perfil"
                  id="perfil-data"
                  disabled
                  required>
                  <option value="" disabled>Seleccione un perfil...</option>
                  <option value="1" selected>Operador</option>
                  <option value="2">Administrador</option>
                </select>
              </div>
              <div class="flex-grow-1 mid-input">
                <label for="email-data" class="form-label fw-semibold">Correo electrónico</label>
                <input
                  type="email"
                  class="form-control"
                  id="email-data"
                  name="correo"
                  disabled
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
                  disabled
                  required />
                <input type="hidden" id="user-id" name="id">
              </div>
            </div>

            <hr class="my-4 text-secondary opacity-25" />

            <div
              class="d-flex flex-wrap justify-content-between align-items-center gap-2">
              <div>
              </div>
              <div class="d-flex gap-2">
                <a
                  href="user/index"
                  class="btn btn-light px-4">Regresar</a>
                <button type="button" class="btn btn-primary px-4 btnEditar">
                  Editar contraseña
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div id="contenedor-cambio-clave" class="card rounded-3 shadow-sm border-light mt-4 d-none">
          </div>
    </div>
  </section>
  