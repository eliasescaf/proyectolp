export const view = {
  getForm: () => document.querySelector("#form-edit"),
  getCampos: () =>
    document.querySelectorAll("#form-edit input, #form-edit select"),

  enableForm: function (estado) {
    const campos = this.getCampos();
    const btnActualizar = document.querySelector(".btnActualizar");
    const btnEditar = document.querySelector(".btnEditar");
    const btnCancelar = document.querySelector(".btnCancelar");
    const toggle = document.getElementById("estado-toggle");

    campos.forEach((campo) => {
      if (!campo.hasAttribute("readonly")) {
        campo.disabled = !estado;
      }
    });

    if (toggle) toggle.disabled = !estado;
    if (btnActualizar) btnActualizar.disabled = !estado;
    if (btnEditar) btnEditar.disabled = estado;
    if (btnCancelar) btnCancelar.disabled = !estado;
  },

  resetForm: function () {
    const form = this.getForm();
    if (form) {
      form.reset();
    }
  },

  showMessage: function (title, icon) {
    Swal.fire({
      title: title,
      icon: icon,
      showConfirmButton: false,
      timer: 3000,
      allowOutsideClick: true,
      allowEscapeKey: true,
    });
  },

  getFormData: function () {
    const form = this.getForm();
    const data = {};
    const inputs = form.querySelectorAll("select, input");

    inputs.forEach((input) => {
      if (input.name) {
        data[input.name] = input.value;
      }
    });

    const toggle = document.getElementById("estado-toggle");
    if (toggle) {
      data["estado"] = toggle.checked ? 1 : 0;
    }

    return data;
  },

  renderTable: function (users) {
    console.log("Usuarios que llegaron al renderTable:", users);

    const tbody = document.getElementById("user-table-body");
    if (!tbody) return;
    tbody.innerHTML = "";

    if (users.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-3 small bg-light">
                        No se encontraron usuarios registrados
                    </td>
                </tr>`;
            return;
        }

    users.forEach((user) => {
      const filaDesactivada =
        user.estado == 0 || user.estado == "Inactivo"
          ? "opacity-50 text-muted bg-light-subtle"
          : "";

      const row = `
                <tr class="${filaDesactivada}">
                    <td>${user.nombre}</td>
                    <td>${user.cuenta}</td>
                    <td>${user.perfil == "1" ? "Operador" : "Administrador"}</td>
                    <td>${user.correo}</td>
                    <td>
                        <a href="user/edit?id=${user.id}" class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
            `;
      tbody.innerHTML += row;
    });
  },

  renderForm: function (user) {
    const idInput = document.getElementById("user-id");
    if (idInput) idInput.value = user.id;

    const nombreInput = document.getElementById("nombre-data");
    if (nombreInput) nombreInput.value = user.nombre;

    const cuentaInput = document.getElementById("cuenta-data");
    if (cuentaInput) cuentaInput.value = user.cuenta;

    const emailInput = document.getElementById("email-data");
    if (emailInput) emailInput.value = user.correo;

    const passInput = document.getElementById("contraseña-data");
    if (passInput) passInput.value = "";

    const perfilSelect = document.getElementById("perfil-data");
    if (perfilSelect) {
      perfilSelect.value = user.perfil.toString();
    }

    const fechaData = document.getElementById("fecha-data");
    if (fechaData) {
      fechaData.textContent = `Creado el: ${user.fechaAlta}`;
    }

    const toggle = document.getElementById("estado-toggle");
    const estadoData = document.getElementById("estado-data");

    if (toggle && estadoData) {
      const esActivo = user.estado == 1 || user.estado == "Activo";
      toggle.checked = esActivo;

      if (esActivo) {
        estadoData.textContent = "Activo";
        estadoData.className = "text-success fw-bold small";
      } else {
        estadoData.textContent = "Inactivo";
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
                ? `Mostrando <span class="fw-bold">${desde}</span> a <span class="fw-bold">${hasta}</span> de <span class="fw-bold">${meta.total_records}</span> usuarios`
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