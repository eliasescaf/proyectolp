export const view = {
    getForm: () => document.querySelector("#form-edit"),
    getCampos : () => document.querySelectorAll("#form-edit input, #form-edit select, #form-edit textarea"),

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
        const data = {};

        const inputs = form.querySelectorAll("select, input, textarea");

        inputs.forEach(input => {
            if(input.name){
                data[input.name] = input.value;
            }
        });
        
        return data;
    },

    renderTable: function(items){
        const tbody = document.getElementById("item-table-body");
        if (!tbody) return;
        tbody.innerHTML = "";

        items.forEach(item => {
            const riegoTexto = item.riego === "1" ? "Bajo" : (item.riego === "2" ? "Medio" : "Alto");
            const catTexto = item.categoria === "1" ? "Interior" : (item.categoria === "2" ? "Exterior" : "Sombra");
            const row = `
                <tr>
                    <td>${item.nombre}</td>
                    <td>${item.codigo || 'N/A'}</td>
                    <td>${riegoTexto}</td>
                    <td>${item.descripcion}</td>
                    <td>${catTexto}</td>
                    <td>${item.precio}</td>
                    <td>${item.stock}</td>
                    <td>
                        <a href="item/edit?id=${item.id}" class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    },

    renderForm: function(item){
        const idInput = document.getElementById("item-id");
        if (idInput) {
            idInput.value = item.id;
        }
        
        document.getElementById("nombre-data").value = item.nombre; 

        const codigoInput = document.getElementById("codigo-data");
        if (codigoInput) {
            codigoInput.value = item.codigo || "";
        }

        document.getElementById("riego-data").value = item.riego;

        document.getElementById("descripcion-data").value = item.descripcion; 
        const catSelect = document.getElementById("categoria-data");
        if(item.categoria == "Interior"){
            catSelect.value = "1";
        } 
        else if(item.categoria == "Exterior"){
            catSelect.value = "2";
        }
        else{
            catSelect.value = "3";
        }
        document.getElementById("precio-data").value = item.precio; 
        document.getElementById("stock-data").value = item.stock; 

        const fechaData = document.getElementById("fecha-data");
        const estadoData = document.getElementById("estado-data");

        if(fechaData){
            fechaData.textContent = `Creado el: ${item.fechaAlta}`
        }

        if(estadoData){
            estadoData.textContent = `Estado: ${item.estado}`

            if(item.estado == "Activo"){
                estadoData.className = "badge bg-success";
            }
            else{
                estadoData.className = "badge bg-danger";
            }
        }
    } 
};