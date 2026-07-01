export const view = {
    getForm: () => document.querySelector("#form-edit"),
    getCampos : () => document.querySelectorAll("#form-edit input, #form-edit select, #form-edit textarea, #estado-toggle"),

    enableForm: function(estado){
        const campos = this.getCampos();
        const btnActualizar = document.querySelector(".btnActualizar");
        const btnEditar = document.querySelector(".btnEditar");
        const btnCancelar = document.querySelector(".btnCancelar");
        const toggle = document.getElementById("estado-toggle");

        campos.forEach(campo => {
            if (!campo.hasAttribute('readonly')) {
                campo.disabled = !estado;
            }
        });

        if (toggle) toggle.disabled = !estado;
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
        
        const toggle = document.getElementById("estado-toggle");
        if (toggle) {
            data['estado'] = toggle.checked ? 1 : 0;
        }

        return data;
    },

    renderTable: function(items){
        const tbody = document.getElementById("item-table-body");
        if (!tbody) return;
        tbody.innerHTML = "";
        
        if (items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-3 small">
                        No se encontraron productos registrados
                    </td>
                </tr>`;
            return;
        }
        
        items.forEach(item => {
            const filaDesactivada = (item.estado == 0 || item.estado == "Discontinuado") ? "opacity-50 text-muted bg-light-subtle" : "";
            const riegoTexto = item.riego == "1" ? "Bajo" : (item.riego == "2" ? "Medio" : "Alto");
            const catTexto = item.categoria == "1" ? "Interior" : (item.categoria == "2" ? "Exterior" : "Sombra");
            const row = `
                <tr class="${filaDesactivada}">
                    <td>${item.nombre}</td>
                    <td>${item.codigo || 'N/A'}</td>
                    <td>${riegoTexto}</td>
                    <td class="col-acortada" title="${item.descripcion}">${item.descripcion}</td>
                    <td>${catTexto}</td>
                    <td>$${item.precio.toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
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
        if (catSelect) {
          catSelect.value = item.categoria; 
        }
        document.getElementById("precio-data").value = item.precio; 
        document.getElementById("stock-data").value = item.stock; 

        const fechaData = document.getElementById("fecha-data");

        if(fechaData){
            fechaData.textContent = `Creado el: ${item.fechaAlta}`
        }

        const toggle = document.getElementById("estado-toggle");
        const estadoData = document.getElementById("estado-data");

        if (toggle && estadoData) {
            const esActivo = (item.estado == 1 || item.estado == "Activo");
            toggle.checked = esActivo;

            if (esActivo) {
                estadoData.textContent = "Activo";
                estadoData.className = "text-success fw-bold small";
            } else {
                estadoData.textContent = "Discontinuado";
                estadoData.className = "text-danger fw-bold small";
            }
        }
    },
    
    renderPaginador: function(meta, cambiarPagina){
        const contenedorText = document.getElementById("txt-mostrando-paginas");
        const paginadorUl = document.getElementById("ul-paginacion");

        if(!paginadorUl) return;

        const desde = (meta.current_page - 1) * meta.limit + 1;
        const hasta = Math.min(meta.current_page * meta.limit, meta.total_records);

        if(contenedorText){
            contenedorText.innerHTML = meta.total_records > 0 
                ? `Mostrando <span class="fw-bold">${desde}</span> a <span class="fw-bold">${hasta}</span> de <span class="fw-bold">${meta.total_records}</span> productos`
                : '';
        }

        paginadorUl.innerHTML = '';

        if(meta.total_pages <= 1) return;
        const liAnterior = document.createElement('li');
        liAnterior.className = `page-item ${meta.current_page == 1 ? 'disabled' : ''}`;
        liAnterior.innerHTML = `<button class="page-link text-success">Anterior</button>`;
        if(meta.current_page > 1 ){
            liAnterior.addEventListener("click", () => cambiarPagina(meta.current_page - 1));
        }
        paginadorUl.appendChild(liAnterior);

        for(let i=1; i<=meta.total_pages; i++){
            const liNum = document.createElement("li");
            liNum.className = `page-item ${meta.current_page == i ? 'active' : ''}`;
            
            const claseLink = meta.current_page == i ? 'bg-success border-success text-white' : 'text-success';
            liNum.innerHTML = `<button class="page-link ${claseLink}">${i}</button>`;
            if (meta.current_page != i) {
                liNum.addEventListener("click", () => cambiarPagina(i));
            }
            paginadorUl.appendChild(liNum);
        }

        const liSiguiente = document.createElement("li");
        liSiguiente.className = `page-item ${meta.current_page == meta.total_pages ? 'disabled' : ''}`;
        liSiguiente.innerHTML = `<button class="page-link text-success">Siguiente</button>`;
        if (meta.current_page < meta.total_pages) {
            liSiguiente.addEventListener("click", () => cambiarPagina(meta.current_page + 1));
        }
        paginadorUl.appendChild(liSiguiente);
    }
};