    <div class="w-50 h-100 d-none d-md-block position-relative">
      <div class="texto-flotante"><i class="bi bi-tree me-2"></i>Plantín</div>
      <img
        src="https://plus.unsplash.com/premium_photo-1663962158789-0ab624c4f17d?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        class="w-100 h-100"
      />
    </div>
    <div class="w-50 d-flex flex-column justify-content-end align-items-center">
      <div id="form-entero">
        <div>
          <p class="text-success fw-bold">Bienvenido</p>
          <h2 class="fw-bold">Iniciar sesión</h2>
          <p class="text-secondary small">
            Obtenga sus plantas junto a nosotros
          </p>
        </div>
        <form id="login-form" action="home/index" autocomplete="off">
          <div class="mb-3">
            <label for="usuario-data" class="form-label">Usuario</label>
            <div class="input-group">
              <span class="input-group-text shadow-sm"
                ><i class="bi bi-person-circle"></i
              ></span>
              <input
                type="text"
                id="usuario-data"
                name="usuario-data"
                class="form-control shadow-sm"
                pattern="^[a-zA-Z0-9]+$"
                required
                placeholder="Ingrese su usuario..."
              />
            </div>
          </div>
          <div class="mb-4">
            <label for="password-data" class="form-label">Contraseña</label>
            <div class="input-group">
              <span class="input-group-text shadow-sm"
                ><i class="bi bi-key"></i
              ></span>
              <input
                type="password"
                name="password-data"
                id="password-data"
                class="form-control shadow-sm"
                required
                minlength="8"
                placeholder="Ingrese su contraseña..."
              />
            </div>
          </div>
          <button type="submit" class="btn btn-success py-2 w-100">
            Iniciar sesión
          </button>
        </form>
      </div>
    </div>
