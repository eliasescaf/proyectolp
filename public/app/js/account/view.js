export const view = {
    getContenedorClave: () => document.getElementById("contenedor-cambio-clave"),
    getBtnEditar: () => document.querySelector(".btnEditar"),

    renderFormularioContraseña: function() {
        const contenedor = this.getContenedorClave();
        if(!contenedor){
            return;
        }

        contenedor.innerHTML = `
        <div class="card-header bg-white py-3">
                <h6 class="fw-bold text-success mb-0">
                    Cambiar contraseña
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <div class="flex-grow-1 mid-input">
                        <label for="pass-nueva" class="form-label fw-semibold">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="pass-nueva" name="password_nueva" minlength="8" required />
                    </div>
                    <div class="flex-grow-1 mid-input">
                        <label for="pass-confirmar" class="form-label fw-semibold">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="pass-confirmar" name="password_confirmar" minlength="8" required />
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light px-4 btnCancelarClave">Cancelar</button>
                    <button type="button" class="btn btn-success px-4 btnGuardarClave">Guardar Contraseña</button>
                </div>
            </div>
        `

        contenedor.classList.remove("d-none");

        const btnEditar = this.getBtnEditar();
        if(btnEditar){
            btnEditar.disabled = true;
        }
    },

    ocultarFormularioContraseña: function(){
        const contenedor = this.getContenedorClave();
        if(contenedor){
            contenedor.innerHTML = "";
            contenedor.classList.add("d-none");
        }
        const btnEditar = this.getBtnEditar();
        if(btnEditar){
            btnEditar.disabled = false;
        }
    },

    renderForm: function(user) {
        const nombreInput = document.getElementById("nombre-data");
        if (nombreInput) nombreInput.value = user.nombre; 

        const cuentaInput = document.getElementById("cuenta-data");
        if (cuentaInput) cuentaInput.value = user.cuenta; 
        
        const emailInput = document.getElementById("email-data");
        if (emailInput) emailInput.value = user.correo; 

        const perfilSelect = document.getElementById("perfil-data");
        if (perfilSelect) perfilSelect.value = user.perfil.toString();

        const fechaData = document.getElementById("fecha-data");
        if (fechaData) fechaData.textContent = `Creado el: ${user.fechaAlta}`;
    },

    showMessage: function(title, icon) {
        Swal.fire({
            title: title,
            icon: icon,
            showConfirmButton: false,
            timer: 3000,
            allowOutsideClick: true,
            allowEscapeKey: true,
        });
    },

}