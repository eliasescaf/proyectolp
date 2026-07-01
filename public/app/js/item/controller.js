import { view } from "./view.js";
import { service } from "./service.js";

let paginaActual = 1;
let filtrosActuales = {
    buscar: "",
    categoria: ""
}

export const controller = {
  init: function () {
    this.list();
    this.bindEvents();
    this.initSuggestiveProduct();
  },

  initSuggestiveProduct: function () {
    const inputBusqueda = document.getElementById("input-sugestivo-producto");
    const contenedorSugerencias = document.getElementById(
      "contenedor-sugerencias",
    );
    const inputHiddenId = document.getElementById("producto-id-seleccionado");
    const txtPrecioUnitario = document.getElementById("txt-precio-unitario");
    const inputCantidad = document.getElementById("input-cantidad");

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

      const res = await service.getSuggestions(query);

      if (res.success && res.data.records && res.data.records.length > 0) {
        contenedorSugerencias.innerHTML = "";
        contenedorSugerencias.style.display = "block";

        res.data.records.forEach((item, index) => {
          const li = document.createElement("li");
          li.className =
            "dropdown-item d-flex justify-content-between align-items-center item-sugerido";
          li.setAttribute("data-index", index);
          li.style.cursor = "pointer";

          li.innerHTML = `
                  <div>
                      <span class="fw-bold text-dark">${item.nombre}</span>
                      <small class="text-muted d-block">Mnemónico: ${item.codigo} | Stock: ${item.stock}</small>
                  </div>
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">$${parseFloat(item.precio).toLocaleString("es-AR", { minimumFractionDigits: 2 })}</span>
              `;

          li.addEventListener("click", () => self.seleccionarItem(item));

          contenedorSugerencias.appendChild(li);
        });
      } else {
        contenedorSugerencias.innerHTML =
          '<li class="dropdown-item text-muted small py-2">No se encontraron artículos...</li>';
        contenedorSugerencias.style.display = "block";
      }
    });

    document.addEventListener("click", function (e) {
      if (e.target !== inputBusqueda && e.target !== contenedorSugerencias) {
        contenedorSugerencias.style.display = "none";
      }
    });
  },

  seleccionarItem: function (item) {
    const inputBusqueda = document.getElementById("input-sugestivo-producto");

    inputBusqueda.value = item.nombre;
    document.getElementById("producto-id-seleccionado").value = item.id;
    document.getElementById("txt-precio-unitario").innerText =
      `$${parseFloat(item.precio).toLocaleString("es-AR", { minimumFractionDigits: 2 })}`;

    const inputCantidad = document.getElementById("input-cantidad");
    inputCantidad.max = item.stock;
    inputCantidad.value = 1;

    inputBusqueda.setAttribute("data-precio", item.precio);
    inputBusqueda.setAttribute("data-stock", item.stock);

    document.getElementById("contenedor-sugerencias").style.display = "none";
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
        const id = document.getElementById("item-id").value;
        this.load(id);
        view.enableForm(false);
      });
    }

    const btnEliminar = document.querySelector(".btnEliminar");
    if (btnEliminar) {
      btnEliminar.addEventListener("click", () => {
        const id = document.getElementById("item-id").value;
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
          estadoData.textContent = "Discontinuado";
          estadoData.className = "text-danger fw-bold small";
        }
      });
    }

      document.getElementById("btn-filtrar-productos")?.addEventListener("click", () => {
      filtrosActuales.buscar = document.getElementById("filtro-buscar-producto").value.trim();
      filtrosActuales.categoria = document.getElementById("filtro-categoria-producto").value;
      paginaActual = 1;
      this.list(); 
    });

      document.getElementById("btn-limpiar-productos")?.addEventListener("click", () => {
      filtrosActuales.buscar = "";
      filtrosActuales.categoria = "";
      paginaActual = 1;

      const inputBuscar = document.getElementById("filtro-buscar-producto");
      const selectCat = document.getElementById("filtro-categoria-producto");
      if (inputBuscar) inputBuscar.value = "";
      if (selectCat) selectCat.value = "";

      this.list();
    });
  },

  load: function (id) {
    service.load(id).then((data) => {
      if (data) {
        view.renderForm(data);
      } else {
        view.showMessage("Error al cargar producto", "error");
      }
    });
  },

  save: function () {
    const data = view.getFormData();
    service.save(data).then((result) => {
      if (result.success) {
        view.showMessage("Registro guardado", "success");
        setTimeout(() => {
          window.location.href = "item/index";
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
          window.location.href = "item/index";
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
              window.location.href = "item/index";
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
      categoria: filtrosActuales.categoria
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
        console.error("Hubo un problema al listar ventas", err);
      });
  },

  exportToPDF: function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const data = view.getFormData();

    const estado = document.getElementById("estado-data")?.textContent || "N/A";
    const fecha = document.getElementById("fecha-data")?.textContent || "N/A";

    const riegoTexto =
      data.riego === "1" ? "Bajo" : data.riego === "2" ? "Medio" : "Alto";
    const catTexto =
      data.categoria === "1"
        ? "Interior"
        : data.categoria === "2"
          ? "Exterior"
          : "Sombra";

    doc.setFontSize(16);
    doc.text("Ficha de Planta", 14, 20);

    doc.setFontSize(12);
    doc.text(`Nombre: ${data.nombre}`, 14, 32);
    doc.text(`Código: ${data.codigo || "N/A"}`, 14, 40);
    doc.text(`Riego: ${riegoTexto}`, 14, 50);
    doc.text(`Descripcion: ${data.descripcion}`, 14, 60);
    doc.text(`Categoria: ${catTexto}`, 14, 70);
    doc.text(`Precio: ${data.precio}`, 14, 80);
    doc.text(`Stock: ${data.stock}`, 14, 90);
    doc.text(estado, 14, 100);
    doc.text(fecha, 14, 110);

    doc.save(`planta_${data.nombre}.pdf`);
  },

  exportListToPDF: function () {
    if (!window.jspdf) {
      console.error("jsPDF no está cargado");
      return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(16);
    doc.text("Listado de plantas: ", 14, 20);

    const hoy = new Date();
    const fechaFormateada = hoy.toLocaleDateString("es-AR");
    doc.setFontSize(10);
    doc.text(`Fecha de emisión: ${fechaFormateada}`, 14, 26);

    doc.setFontSize(12);

    doc.autoTable({
      html: "#item-table",
      startY: 40,
      theme: "striped",
      headStyles: { fillColor: [40, 167, 69] },
      columns: [0, 1, 2, 3, 4, 5, 6],
    });

    doc.save("listado_plantas.pdf");
  },
};