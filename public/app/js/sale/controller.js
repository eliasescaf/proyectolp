import { service } from "./service.js";
import { view } from "./view.js";

let carrito = []; 
let totalGeneral = 0.0;
let montoDescuento = 0.0;
let paginaActual = 1;
let filtrosActuales = {
    buscar: "",
    fecha_inicio: "",
    fecha_fin: ""
};

export const controller = {
    init: function() {
        this.list();
        this.bindEventsHistorial(); 
        this.bindModalEvents();    
    },

    list: function() {
        const parametros = {
            page: paginaActual,
            limit: 10,
            buscar: filtrosActuales.buscar,
            fecha_inicio: filtrosActuales.fecha_inicio,
            fecha_fin: filtrosActuales.fecha_fin
        }
        service.list(parametros).then(res => {
            if (res.success && res.data) {
                view.renderTable(res.data.records);
                view.renderPaginador(res.data.meta, (nroPaginaSeleccionada) => {
                    paginaActual = nroPaginaSeleccionada; 
                    this.list();
                });
            } else {
                view.renderTable(res); 
            }
        }).catch(err => console.error("Hubo un problema al listar ventas", err));
    },

    bindEventsHistorial: function() {
        const tableBody = document.getElementById("sales-table-body");
        tableBody?.addEventListener("click", (e) => {
            const btnDetalle = e.target.closest(".btnVerDetalle");
            if (btnDetalle) {
                const idVenta = btnDetalle.getAttribute("data-id");
                service.load(idVenta).then(venta => {
                    if (venta) view.mostrarDetalleModal(venta);
                    else view.showMessage("No se pudo cargar el detalle", "error");
                });
                return;
            }
            const btnPdf = e.target.closest(".btnComprobantePDF");
            if (btnPdf) this.exportToPDF(btnPdf.getAttribute("data-id"));
        });

        document.querySelector(".btnExportarListado")?.addEventListener("click", () => {
            this.exportListToPDF();
        });

        document.getElementById("btn-aplicar-filtros")?.addEventListener("click", () => {
            filtrosActuales.buscar = document.getElementById("filtro-buscar").value.trim();
            filtrosActuales.fecha_inicio = document.getElementById("filtro-fecha-inicio").value;
            filtrosActuales.fecha_fin = document.getElementById("filtro-fecha-fin").value;
            paginaActual = 1;
            this.list();
        });

        document.getElementById("btn-limpiar-filtros")?.addEventListener("click", () => {
            filtrosActuales.buscar = "";
            filtrosActuales.fecha_inicio = "";
            filtrosActuales.fecha_fin = "";
            paginaActual = 1;

            const inputBuscar = document.getElementById("filtro-buscar");
            const inputInicio = document.getElementById("filtro-fecha-inicio");
            const inputFin = document.getElementById("filtro-fecha-fin");

            if (inputBuscar) inputBuscar.value = "";
            if (inputInicio) inputInicio.value = "";
            if (inputFin) inputFin.value = "";
            this.list();
        });
    },

    bindModalEvents: function() {
        document.querySelector(".btnImprimirTicketModal")?.addEventListener("click", (e) => {
            const idVenta = e.currentTarget.getAttribute("data-id");
            if (idVenta) this.exportToPDF(idVenta);
        });

        document.querySelector(".btnBorrarVenta")?.addEventListener("click", () => {
            const idVenta = document.querySelector(".btnImprimirTicketModal")?.getAttribute("data-id");
            if (!idVenta) return view.showMessage("No se identificó la transacción", "error");

            Swal.fire({
                title: "¿Estás seguro de eliminar esta venta?",
                text: "Esta acción es irreversible. Se reintegrarán los productos al stock.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                confirmButtonColor: "#dc3545",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#636366"
            }).then((result) => {
                if (result.isConfirmed) {
                    service.delete(idVenta).then(response => {
                        if (response.success) {
                            const modalInstancia = bootstrap.Modal.getInstance(document.getElementById('detalleVentaModal'));
                            modalInstancia?.hide();
                            view.showMessage(response.message, "success");
                            this.list(); 
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    });
                }
            });
        });
    },

    bindEventsCreate: function() {
        this.initSuggestiveProduct();
        this.initSuggestiveClient();

        const carritoBody = document.getElementById("carrito-body");

        document.getElementById("btn-agregar-carrito")?.addEventListener("click", () => this.agregarAlCarrito());

        carritoBody?.addEventListener("change", (e) => {
            if (e.target.classList.contains("cambiar-cant")) this.modificarCantidadCarrito(e.target);
        });

        carritoBody?.addEventListener("click", (e) => {
            const btnBorrar = e.target.closest(".btnBorrarItem");
            if (btnBorrar) this.eliminarItemCarrito(parseInt(btnBorrar.getAttribute("data-id")));
        });
        
        document.getElementById("select-forma-pago")?.addEventListener("change", (e) => this.manejarCambioPago(e.target));
        document.getElementById("check-descuento")?.addEventListener("change", () => this.actualizarTotalesEnPantalla());

        document.getElementById("btn-guardar-venta")?.addEventListener("click", () => this.procesarGuardadoVenta());
    },

    agregarAlCarrito: function() {
        const inputBusqueda = document.getElementById('input-sugestivo-producto');
        const inputHiddenId = document.getElementById('producto-id-seleccionado');
        const inputCant = document.getElementById("input-cantidad");

        if (!inputHiddenId.value) return view.showMessage("Seleccione un producto válido de las sugerencias", "error");

        const idProducto = parseInt(inputHiddenId.value);
        const precio = parseFloat(inputBusqueda.getAttribute("data-precio")) || 0;
        const stock = parseInt(inputBusqueda.getAttribute("data-stock")) || 0;
        const cantidad = parseInt(inputCant.value);

        if (cantidad <= 0) return view.showMessage("La cantidad debe ser mayor a 0", "error");
        if (cantidad > stock) return view.showMessage(`Stock insuficiente. Máximo: ${stock}`, "error");

        const index = carrito.findIndex(item => item.item_id === idProducto);
        if (index !== -1) {
            if ((carrito[index].cantidad + cantidad) > stock) return view.showMessage(`Supera el stock de ${stock}`, "error");
            carrito[index].cantidad += cantidad;
            carrito[index].subtotal = carrito[index].cantidad * precio;
        } else {
            carrito.push({ item_id: idProducto, nombre: inputBusqueda.value, cantidad, precio_unitario: precio, subtotal: cantidad * precio, stock });
        }

        this.refrescarCaja();
        inputBusqueda.value = ""; inputHiddenId.value = ""; inputCant.value = 1;
        document.getElementById('txt-precio-unitario').textContent = "$0,00";
    },

    modificarCantidadCarrito: function(input) {
        const idProducto = parseInt(input.getAttribute("data-id"));
        const nuevaCantidad = parseInt(input.value);
        const item = carrito.find(p => p.item_id === idProducto);
        
        if (!item) return;
        if (nuevaCantidad > item.stock) {
            view.showMessage(`Stock máximo disponible: ${item.stock}`, "error");
            view.renderCarrito(carrito);
            return;
        }
        if (nuevaCantidad <= 0) return;

        item.cantidad = nuevaCantidad;
        item.subtotal = nuevaCantidad * item.precio_unitario;
        this.refrescarCaja();
    },

    eliminarItemCarrito: function(idProducto) {
        carrito = carrito.filter(item => item.item_id !== idProducto);
        this.refrescarCaja();
    },

    manejarCambioPago: function(select) {
        const checkDescuento = document.getElementById("check-descuento");
        if (select.value === "Efectivo") {
            if (checkDescuento) checkDescuento.disabled = false;
        } else {
            if (checkDescuento) { checkDescuento.checked = false; checkDescuento.disabled = true; }
            montoDescuento = 0.0;
            this.actualizarTotalesEnPantalla();
        }
    },

    actualizarTotalesEnPantalla: function() {
        const checkDescuento = document.getElementById("check-descuento");
        montoDescuento = (checkDescuento && checkDescuento.checked) ? totalGeneral * 0.21 : 0.0;
        
        const totalConDescuento = totalGeneral - montoDescuento;
        const txtDescuento = document.getElementById("txt-descuento");
        
        if (txtDescuento) {
            txtDescuento.textContent = montoDescuento > 0 ? `-$${montoDescuento.toLocaleString('es-AR', { minimumFractionDigits: 2 })}` : "$0,00";
        }
        document.getElementById("txt-total-general").textContent = `$${totalConDescuento.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;
    },

    refrescarCaja: function() {
        totalGeneral = view.renderCarrito(carrito);
        this.actualizarTotalesEnPantalla();
    },

    procesarGuardadoVenta: function() {
        const formaPago = document.getElementById("select-forma-pago").value;
        const idCliente = document.getElementById("cliente-id-seleccionado")?.value || null;

        if (carrito.length === 0) return view.showMessage("El detalle de la transacción está vacío", "error");
        if (!formaPago) return view.showMessage("Seleccione una forma de pago válida", "error");

        const paqueteVenta = {
            cliente_id: idCliente ? parseInt(idCliente) : null,
            forma_pago: formaPago, 
            descuento: montoDescuento,
            total: totalGeneral - montoDescuento,
            productos: carrito.map(item => ({
                item_id: item.item_id,
                nombre_item: item.nombre,
                cantidad: item.cantidad,
                precio_unitario: item.precio_unitario
            }))
        };

        service.save(paqueteVenta).then(res => {
            if (res.success) {
                Swal.fire({
                    title: "¡Venta procesada con éxito!",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#28a745",
                    allowOutsideClick: false
                }).then(() => { carrito = []; window.location.href = "sale/index"; });
            } else {
                view.showMessage(`Error: ${res.message}`, "error");
            }
        });
    },


    initSuggestiveProduct: function() {
        const inputBusqueda = document.getElementById('input-sugestivo-producto');
        const contenedorSugerencias = document.getElementById('contenedor-sugerencias');
        const self = this;

        inputBusqueda?.addEventListener('keyup', async function(e) {
            const teclasDeControl = [
                "ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight", 
                "Enter", "Escape", "Shift", "Control", "Alt"
            ];

            if (teclasDeControl.includes(e.key)) {
                if (e.key === "Escape") {
                    contenedorSugerencias.style.display = 'none';
                }
                return; 
            }

            const query = e.target.value.trim();

            if (query.length < 2) {
                contenedorSugerencias.innerHTML = '';
                contenedorSugerencias.style.display = 'none';
                return;
            }

            const res = await service.getProductSuggestions(query);

            if (res.success && res.data.records && res.data.records.length > 0) {
                contenedorSugerencias.innerHTML = '';
                contenedorSugerencias.style.display = 'block';

                res.data.records.forEach((item, id) => {
                    const li = document.createElement('li');
                    li.className = 'dropdown-item d-flex justify-content-between align-items-center item-sugerido';
                    li.setAttribute('data-id', id);
                    li.style.cursor = 'pointer';
                    
                    li.innerHTML = `
                        <div class="d-flex w-100 justify-content-between align-items-center py-1">
                            <div>
                                <span class="text-dark fw-medium d-block mb-0 titulo-sugestivo">${item.nombre}</span>
                                <span class="text-muted desc-sugestivo">
                                    ${item.codigo} <span class="text-neutral-300 mx-1">•</span> Stock: ${item.stock}
                                </span>
                            </div>
                            <span class="text-dark fw-semibold desc-sugestivo">
                                $${parseFloat(item.precio).toLocaleString('es-AR', { minimumFractionDigits: 2 })}
                            </span>
                        </div>
                    `;

                    li.addEventListener('click', () => self.seleccionarItem(item));

                    contenedorSugerencias.appendChild(li);
                });
            } else {
                contenedorSugerencias.innerHTML = '<li class="dropdown-item text-muted small py-2">No se encontraron artículos...</li>';
                contenedorSugerencias.style.display = 'block';
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target !== inputBusqueda && e.target !== contenedorSugerencias) {
                contenedorSugerencias.style.display = 'none';
            }
        });
    },

    seleccionarItem: function(item) {
        const inputBusqueda = document.getElementById('input-sugestivo-producto');
        
        inputBusqueda.value = item.nombre;
        document.getElementById('producto-id-seleccionado').value = item.id;
        document.getElementById('txt-precio-unitario').innerText = `$${parseFloat(item.precio).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;
        
        const inputCantidad = document.getElementById('input-cantidad');
        inputCantidad.max = item.stock;
        inputCantidad.value = 1;

        inputBusqueda.setAttribute('data-precio', item.precio);
        inputBusqueda.setAttribute('data-stock', item.stock);

        document.getElementById('contenedor-sugerencias').style.display = 'none';
    },

    initSuggestiveClient: function() {
        const inputBusqueda = document.getElementById('input-sugestivo-cliente');
        const contenedorSugerencias = document.getElementById('contenedor-sugerencias-cliente');
        const self = this;

        inputBusqueda?.addEventListener('keyup', async function(e) {
            const teclasDeControl = [
                "ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight", 
                "Enter", "Escape", "Shift", "Control", "Alt"
            ];

            if (teclasDeControl.includes(e.key)) {
                if (e.key === "Escape") {
                    contenedorSugerencias.style.display = 'none';
                }
                return; 
            }

            const query = e.target.value.trim();

            if (query.length < 2) {
                contenedorSugerencias.innerHTML = '';
                contenedorSugerencias.style.display = 'none';
                return;
            }

            const res = await service.getClientSuggestions(query);

            if (res.success && res.data.records && res.data.records.length > 0) {
                contenedorSugerencias.innerHTML = '';
                contenedorSugerencias.style.display = 'block';

                res.data.records.forEach((cliente) => {
                    const li = document.createElement('li');
                    li.className = 'dropdown-item py-2';
                    li.style.cursor = 'pointer';
                    
                    li.innerHTML = `
                        <div class="py-0">
                            <span class="text-dark fw-medium d-block mb-0 titulo-sugestivo">${cliente.nombre}</span>
                            <span class="text-muted desc-sugestivo">DNI/CUIT: ${cliente.dni || cliente.cuit_cuil}</span>
                        </div>
                    `;

                    li.addEventListener('click', () => self.seleccionarCliente(cliente));

                    contenedorSugerencias.appendChild(li);
                });
            } else {
                contenedorSugerencias.innerHTML = '<li class="dropdown-item text-muted small py-2">No se encontró el cliente...</li>';
                contenedorSugerencias.style.display = 'block';
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target !== inputBusqueda && e.target !== contenedorSugerencias) {
                contenedorSugerencias.style.display = 'none';
            }
        });
    },

    seleccionarCliente: function(cliente) {
        const inputBusqueda = document.getElementById('input-sugestivo-cliente');
        const inputHiddenId = document.getElementById('cliente-id-seleccionado');

        inputBusqueda.value = cliente.nombre;
        inputHiddenId.value = cliente.id;
        document.getElementById('contenedor-sugerencias-cliente').style.display = 'none';
    },

    exportToPDF: function(id){
        service.load(id).then(venta => {
            if(!venta){
                view.showMessage("No se encontró la información para generar el comprobante", "error");
                return;
            }
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFontSize(16);
            doc.text("COMPROBANTE DE VENTA", 14, 20);
            
            doc.setFontSize(10);

            doc.text(`Nro. Transacción: #${String(venta.numero_venta).padStart(5, '0')}`, 14, 28);
            doc.text(`Fecha y Hora: ${venta.fecha}`, 14, 34);
            doc.text(`Cliente: ${venta.cliente_nombre || "Consumidor Final"}`, 14, 40); 
            doc.text(`Forma de Pago: ${venta.forma_pago || "No especificada"}`, 14, 46); 
            doc.text(`Operador: ${venta.usuario_nombre}`, 14, 52); 

            const filasTabla = venta.detalles.map(linea => [
                linea.nombre_item,
                linea.cantidad,
                `$${parseFloat(linea.precio_unitario).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`,
                `$${parseFloat(linea.subtotal).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`
            ]);

            doc.autoTable({
                startY: 58,
                head: [['Producto / Planta', 'Cantidad', 'Precio Unitario', 'Subtotal']],
                body: filasTabla,
                theme: 'striped',
                headStyles: { fillColor: [40, 167, 69] }
            });

            let finalY = doc.lastAutoTable.finalY + 12; 
            doc.setFontSize(12);
            doc.text("Descuento:", 140, finalY);
            doc.text(`$${parseFloat(venta.descuento).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`, 196, finalY, { align: 'right' });
            
            doc.text("Monto Total:", 140, finalY + 6);
            doc.text(`$${parseFloat(venta.total).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`, 196, finalY + 6, { align: 'right' });
            
            doc.save(`comprobante_venta_${venta.numero_venta}.pdf`);
        });
    },

    exportListToPDF: function(){
        if (!window.jspdf) return console.error("jsPDF no está cargado");
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.text("Listado de ventas: ", 14, 20);

        const hoy = new Date();
        const fechaFormateada = hoy.toLocaleDateString("es-AR");
        doc.setFontSize(10);
        doc.text(`Fecha de emisión: ${fechaFormateada}`, 14, 26)

        doc.setFontSize(12);
        doc.autoTable({
            html:"#sales-table",
            startY: 40,
            theme: 'striped',
            headStyles: { fillColor: [40, 167, 69]},
            columns: [0, 1, 2, 3]
        });
        doc.save("listado_ventas.pdf");
    }
};