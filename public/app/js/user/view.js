export const view = {
    getForm: () => document.querySelector("#form-edit"),
    getCampos : () => document.querySelectorAll("#form-edit input, #form-edit select"),

    enableForm: function(estado){
        const campos = this.getCampos();
        const btnActualizar = document.querySelector(".btnActualizar");
        const btnEditar = document.querySelector(".btnEditar");
        const btnCancelar = document.querySelector(".btnCancelar");

        campos.forEach(campo => {
            if (!campo.hasAttribute('readonly')) {
                campo.disabled = !estado;
            }
        });

        if(btnActualizar) btnActualizar.disabled = !estado;
        if(btnEditar) btnEditar.disabled = estado;
        if(btnCancelar) btnCancelar.disabled = !estado;
    },

    resetForm: function() {
        const form = this.getForm();
        if(form){
            form.reset();
        };
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

    getFormData: function(){
        const form = this.getForm();
        const formData = new FormData(form);
        return Object.fromEntries(formData.entries());
    },

    renderTable: function(users){
        const tbody = document.getElementById("user-table-body");
        tbody.innerHTML = "";

        users.forEach(user => {
            const row = `
                <tr>
                    <td>${user.nombre}</td>
                    <td>${user.cuenta}</td>
                    <td>${user.perfil}</td>
                    <td>${user.correo}</td>
                    <td>
                        <a href="app/resources/views/user/edit.html?id=${user.id}" class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    },

    renderForm: function(user){
        const idInput = document.getElementById("user-id");
        if (idInput) {
            idInput.value = user.id;
        }
        
        document.getElementById("nombre-data").value = user.nombre; 
        document.getElementById("cuenta-data").value = user.cuenta; 
        const perfilSelect = document.getElementById("perfil-data");
        if(user.perfil == "operador"){
            perfilSelect.value = "1";
        } 
        else{
            perfilSelect.value = "2";
        }
        document.getElementById("email-data").value = user.correo; 
        document.getElementById("contraseña-data").value = user.contraseña; 

        const fechaData = document.getElementById("fecha-data");
        const estadoData = document.getElementById("estado-data");

        if(fechaData){
            fechaData.textContent = `Creado el: ${user.fechaAlta}`
        }

        if(estadoData){
            estadoData.textContent = `Estado: ${user.estado}`

            if(user.estado == "Activo"){
                estadoData.className = "badge bg-success";
            }
            else{
                estadoData.className = "badge bg-danger";
            }
        }
    } 
};