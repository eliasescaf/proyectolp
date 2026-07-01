import { view } from "./view.js";
import { service } from "./service.js";

let paginaActual = 1;
let filtrosActuales = {
    tipo: '',
    buscar: ''
}

export const controller = {
  init: function () {
    this.list();
    this.bindEvents();
  },

  initSuggestiveClient: function () {
    const inputBusqueda = document.getElementById("input-sugestivo-cliente");
    const contenedorSugerencias = document.getElementById(
      "contenedor-sugerencias-cliente",
    );
    const self = this;

    inputBusqueda?.addEventListener("keyup", async function (e) {
      const teclasDeControl = [
        "ArrowUp",
        "ArrowDown",
        "ArrowLeft",
        "ArrowRight",
        "Enter",
        "Escape",
        "Shift",
        "Control",
        "Alt",
      ];

      if (teclasDeControl.includes(e.key)) {
        if (e.key === "Escape") {
          contenedorSugerencias.style.display = "none";
        }
        return;
      }

      const query = e.target.value.trim();

      if (query.length < 2) {
        contenedorSugerencias.innerHTML = "";
        contenedorSugerencias.style.display = "none";
        return;
      }

      const res = await service.getClientSuggestions(query);

      if (res.success && res.data.records && res.data.records.length > 0) {
        contenedorSugerencias.innerHTML = "";
        contenedorSugerencias.style.display = "block";

        res.data.records.forEach((cliente) => {
          const li = document.createElement("li");
          li.className = "dropdown-item py-2";
          li.style.cursor = "pointer";

          li.innerHTML = `
                          <div class="py-0">
                              <span class="text-dark fw-medium d-block mb-0 titulo-sugestivo">${cliente.nombre}</span>
                              <span class="text-muted desc-sugestivo">DNI/CUIT: ${cliente.documento || cliente.dni}</span>
                          </div>
                      `;

          li.addEventListener("click", () => self.seleccionarCliente(cliente));

          contenedorSugerencias.appendChild(li);
        });
      } else {
        contenedorSugerencias.innerHTML =
          '<li class="dropdown-item text-muted small py-2">No se encontró el cliente...</li>';
        contenedorSugerencias.style.display = "block";
      }
    });

    document.addEventListener("click", function (e) {
      if (e.target !== inputBusqueda && e.target !== contenedorSugerencias) {
        contenedorSugerencias.style.display = "none";
      }
    });
  },

  seleccionarCliente: function (cliente) {
    const inputBusqueda = document.getElementById("input-sugestivo-cliente");
    const inputHiddenId = document.getElementById("cliente-id-seleccionado");

    inputBusqueda.value = cliente.nombre;
    inputHiddenId.value = cliente.id;
    document.getElementById("contenedor-sugerencias-cliente").style.display =
      "none";
  },

  bindEvents: function () {
    const btnActualizar = document.querySelector(".btnActualizar");
    if (btnActualizar) {
      btnActualizar.addEventListener("click", (e) => {
        e.preventDefault();
        this.update();
      });
    }

    const btnEditar = document.querySelector(".btnEditar");
    if (btnEditar) {
      btnEditar.addEventListener("click", () => view.enableForm(true));
    }

    const btnCancelar = document.querySelector(".btnCancelar");
    if (btnCancelar) {
      btnCancelar.addEventListener("click", () => {
        const id = document.getElementById("client-id").value;
        this.load(id);
        view.enableForm(false);
      });
    }

    const btnEliminar = document.querySelector(".btnEliminar");
    if (btnEliminar) {
      btnEliminar.addEventListener("click", () => {
        const id = document.getElementById("client-id").value;
        this.delete(id);
      });
    }

    const btnGuardar = document.querySelector(".btnGuardar");
    if (btnGuardar) {
      btnGuardar.addEventListener("click", (e) => {
        e.preventDefault();
        this.save();
      });
    }

    const btnPDF = document.querySelector(".btnPDF");
    if (btnPDF) {
      btnPDF.addEventListener("click", () => {
        this.exportToPDF();
      });
    }

    const btnListado = document.querySelector(".btnExportarListado");
    if (btnListado) {
      btnListado.addEventListener("click", () => {
        this.exportListToPDF();
      });
    }
    

    const toggle = document.getElementById("estado-toggle");
    const estadoData = document.getElementById("estado-data");

    if (toggle && estadoData) {
      toggle.addEventListener("change", (e) => {
        if (e.target.checked) {
          estadoData.textContent = "Activo";
          estadoData.className = "text-success fw-bold small";
        } else {
          estadoData.textContent = "Inactivo";
          estadoData.className = "text-danger fw-bold small";
        }
      });
    }

    document.getElementById("btn-filtrar-clientes")?.addEventListener("click", () => {
            filtrosActuales.buscar = document.getElementById("filtro-buscar").value.trim();
            filtrosActuales.tipo = document.getElementById("filtro-tipo-cliente").value;
            paginaActual = 1;
            this.list();
        });

    document.getElementById("btn-limpiar-clientes")?.addEventListener("click", () => {
            filtrosActuales.tipo = "";
            filtrosActuales.buscar = "";
            paginaActual = 1;

            const inputBuscar = document.getElementById("filtro-buscar");
            const selectTipo = document.getElementById("filtro-tipo-cliente");
            
            if (inputBuscar) inputBuscar.value = "";
            if (selectTipo) selectTipo.value = "";
            this.list();
        });
  },

  load: function (id) {
    service.load(id).then((data) => {
      if (data) {
        view.renderForm(data);
      } else {
        view.showMessage("Error al cargar cliente", "error");
      }
    });
  },

  save: function () {
    const data = view.getFormData();
    service.save(data).then((result) => {
      if (result.success) {
        view.showMessage("Registro guardado", "success");
        setTimeout(() => {
          window.location.href = "client/index";
        }, 1500);
      } else {
        view.showMessage(result.message, "error");
      }
    });
  },

  update: function () {
    const data = view.getFormData();
    service.update(data).then((result) => {
      if (result.success) {
        view.showMessage("Registro actualizado", "success");
        setTimeout(() => {
          window.location.href = "client/index";
        }, 1500);
      } else {
        view.showMessage(result.message, "error");
      }
    });
  },

  delete: function (id) {
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Esta acción no se puede deshacer",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar",
      confirmButtonColor: "#dc3545",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#636366",
    }).then((result) => {
      if (result.isConfirmed) {
        service.delete(id).then((result) => {
          if (result.success) {
            view.showMessage("Registro eliminado", "success");
            setTimeout(() => {
              window.location.href = "client/index";
            }, 1500);
          } else {
            Swal.fire({
              title: "Acción Bloqueada",
              text: result.message,
              icon: "info",
              confirmButtonColor: "#1c1c1e",
            });
          }
        });
      }
    });
  },

  list: function () {
    const parametros = {
            page: paginaActual,
            limit: 10,
            buscar: filtrosActuales.buscar,
            tipo: filtrosActuales.tipo
        }

    service
      .list(parametros)
      .then((res) => {
        if (res.success && res.data) {
          view.renderTable(res.data.records);
          view.renderPaginador(res.data.meta, (nroPaginaSeleccionada) => {
            paginaActual = nroPaginaSeleccionada;
            this.list();
          });
        } else {
          view.renderTable(res);
        }
      })
      .catch((err) => {
        console.error("Hubo un problema al listar productos", err);
      });
  },

  exportToPDF: function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const data = view.getFormData();

    const estado = document.getElementById("estado-data")?.textContent || "N/A";
    const fecha = document.getElementById("fecha-data")?.textContent || "N/A";

    doc.setFontSize(16);
    doc.text("Ficha de Cliente", 14, 20);

    doc.setFontSize(12);
    doc.text(`Nombre: ${data.nombre}`, 14, 32);
    doc.text(`DNI: ${data.dni || "N/A"}`, 14, 40);
    doc.text(`Tipo: ${data.tipo || "N/A"}`, 14, 50);
    doc.text(`Razón Social: ${data.razon || "N/A"}`, 14, 60);
    doc.text(`CUIT/CUIL: ${data.cuit || "N/A"}`, 14, 70);
    doc.text(`Teléfono: ${data.telefono || "N/A"}`, 14, 80);
    doc.text(`Email: ${data.email || "N/A"}`, 14, 90);
    doc.text(estado, 14, 100);
    doc.text(fecha, 14, 110);

    doc.save(`cliente_${data.nombre}.pdf`);
  },

  exportListToPDF: function () {
    if (!window.jspdf) {
      console.error("jsPDF no está cargado");
      return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(16);
    doc.text("Listado de clientes: ", 14, 20);

    const hoy = new Date();
    const fechaFormateada = hoy.toLocaleDateString("es-AR");
    doc.setFontSize(10);
    doc.text(`Fecha de emisión: ${fechaFormateada}`, 14, 26);

    doc.setFontSize(12);

    doc.autoTable({
      html: "#client-table",
      startY: 40,
      theme: "striped",
      headStyles: { fillColor: [40, 167, 69] },
      columns: [0, 1, 2, 3, 4, 5, 6],
    });

    doc.save("listado_clientes.pdf");
  },
};