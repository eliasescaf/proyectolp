import { service } from "./service.js";
import { view } from "./view.js";

let carrito = []; 
let totalGeneral = 0.0;
let montoDescuento = 0.0;
let paginaActual = 1;


export const controller = {
    init: function(){
        this.cargarHistorial();
        const tableBody = document.getElementById("sales-table-body");
        tableBody?.addEventListener("click", (e) => {
            const btnDetalle = e.target.closest(".btnVerDetalle");
            if (btnDetalle){
                const idVenta = btnDetalle.getAttribute("data-id");
                service.load(idVenta).then(venta => {
                    if (venta) view.mostrarDetalleModal(venta);
                    else view.showMessage("No se pudo cargar el detalle de la venta", "error");
                });
                return;
            }

            const btnPdf = e.target.closest(".btnComprobantePDF");
            if(btnPdf) {
                this.exportToPDF(btnPdf.getAttribute("data-id"));
                return;
            }
        });

        document.querySelector(".btnImprimirTicketModal")?.addEventListener("click", (e) => {
            const idVenta = e.currentTarget.getAttribute("data-id");
            if (idVenta) this.exportToPDF(idVenta);
        });

        document.querySelector(".btnExportarListado")?.addEventListener("click", () => {
            this.exportListToPDF();
        });
    },

    cargarHistorial: function() {
        service.list({ page: paginaActual, limit: 10 }).then(res => {
                    
                    if (res.success && res.data) {
                        view.renderTable(res.data.records);
                        view.renderPaginador(res.data.meta, (nroPaginaSeleccionada) => {
                            paginaActual = nroPaginaSeleccionada; 
                            this.cargarHistorial();
                        });
                    } else {
                        view.renderTable(res); 
                    }
        
                }).catch(err => {
                    console.error("Hubo un problema al listar ventas", err);
                });
    },

    bindEventsCreate: function(){
        this.initSuggestiveProduct();
        this.initSuggestiveClient();

        const btnAgregar = document.getElementById("btn-agregar-carrito");
        const carritoBody = document.getElementById("carrito-body");
        const btnGuardar = document.getElementById("btn-guardar-venta");

        const selectPago = document.getElementById("select-forma-pago");
        const checkDescuento = document.getElementById("check-descuento");

        btnAgregar?.addEventListener("click", () => {
            const inputBusqueda = document.getElementById('input-sugestivo-producto');
            const inputHiddenId = document.getElementById('producto-id-seleccionado');
            const inputCant = document.getElementById("input-cantidad");

            if (!inputHiddenId.value) {
                return view.showMessage("Debe seleccionar un producto válido de las sugerencias", "error");
            }

            const idProducto = parseInt(inputHiddenId.value);
            const nombre = inputBusqueda.value;
            const precio = parseFloat(inputBusqueda.getAttribute("data-precio")) || 0;
            const stock = parseInt(inputBusqueda.getAttribute("data-stock")) || 0;
            const cantidad = parseInt(inputCant.value);

            if (cantidad <= 0) return view.showMessage("La cantidad debe ser mayor a 0", "error");
            if (cantidad > stock) return view.showMessage(`No hay stock suficiente. Máximo disponible: ${stock}`, "error");

            const indexExistente = carrito.findIndex(item => item.item_id === idProducto);
            
            if(indexExistente !== -1){
                if((carrito[indexExistente].cantidad + cantidad) > stock) {
                    return view.showMessage(`No podés agregar más de ese producto. Supera el stock de ${stock}`, "error");
                }
                carrito[indexExistente].cantidad += cantidad;
                carrito[indexExistente].subtotal = carrito[indexExistente].cantidad * precio;
            } else {
                carrito.push({ item_id: idProducto, nombre, cantidad, precio_unitario: precio, subtotal: cantidad * precio, stock: stock });
            }

            totalGeneral = view.renderCarrito(carrito);
            actualizarTotalesEnPantalla();

            inputBusqueda.value = "";
            inputHiddenId.value = "";
            inputCant.value = 1;
            document.getElementById('txt-precio-unitario').textContent = "$0,00";
        });

        carritoBody?.addEventListener("change", (e) => {
            if (e.target.classList.contains("cambiar-cant")) {
                const idProducto = parseInt(e.target.getAttribute("data-id"));
                const nuevaCantidad = parseInt(e.target.value);
                
                const item = carrito.find(p => p.item_id === idProducto);
                if (!item) return;

                if (nuevaCantidad > item.stock) {
                    view.showMessage(`Acción rechazada. El stock máximo disponible es ${item.stock}`, "error");
                    view.renderCarrito(carrito); 
                    return;
                }
                if (nuevaCantidad <= 0) return;

                item.cantidad = nuevaCantidad;
                item.subtotal = nuevaCantidad * item.precio_unitario;
                totalGeneral = view.renderCarrito(carrito);
                actualizarTotalesEnPantalla();
            }
        });

        carritoBody?.addEventListener("click", (e) => {
            const btnBorrar = e.target.closest(".btnBorrarItem");
            if(btnBorrar) {
                const idProducto = parseInt(btnBorrar.getAttribute("data-id"));
                carrito = carrito.filter(item => item.item_id !== idProducto);
                totalGeneral = view.renderCarrito(carrito);
                actualizarTotalesEnPantalla();
            }
        });
        
        selectPago?.addEventListener("change", () => {
            if (selectPago.value === "Efectivo") {
                checkDescuento.disabled = false;
            } else {
                checkDescuento.checked = false;
                checkDescuento.disabled = true;
                montoDescuento = 0.0;
                actualizarTotalesEnPantalla();
            }
        });
        
        checkDescuento?.addEventListener("change", () => {
            actualizarTotalesEnPantalla();
        });

        function actualizarTotalesEnPantalla() {
            if (checkDescuento && checkDescuento.checked) {
                montoDescuento = totalGeneral * 0.21; 
            } else {
                montoDescuento = 0.0;
            }

            const totalConDescuento = totalGeneral - montoDescuento;

            const txtDescuento = document.getElementById("txt-descuento");
            if (txtDescuento) {
                txtDescuento.textContent = montoDescuento > 0 
                    ? `-$${montoDescuento.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`
                    : "$0,00";
            }

            document.getElementById("txt-total-general").textContent = 
                `$${totalConDescuento.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;
        }

        btnGuardar?.addEventListener("click", () => {
            const formaPago = document.getElementById("select-forma-pago").value;
            const idCliente = document.getElementById("cliente-id-seleccionado")?.value || null;

            if (carrito.length === 0) return view.showMessage("El detalle de la transacción está vacío", "error");
            if (!formaPago) return view.showMessage("Debe seleccionar una forma de pago válida", "error");

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
                        text: "La transacción fue persistida en la base de datos.",
                        icon: "success",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#28a745",
                        allowOutsideClick: false, 
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            carrito = [];
                            window.location.href = "sale/index";
                        }
                    });
                } else {
                    view.showMessage(`Error del sistema: ${res.message}`, "error");
                }
            });
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
                                <span class="text-dark fw-medium d-block mb-0" style="font-size: 0.95rem;">${item.nombre}</span>
                                <span class="text-muted" style="font-size: 0.8rem;">
                                    ${item.codigo} <span class="text-neutral-300 mx-1">•</span> Stock: ${item.stock}
                                </span>
                            </div>
                            <span class="text-dark fw-semibold" style="font-size: 0.95rem;">
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
                            <span class="text-dark fw-medium d-block mb-0" style="font-size: 0.95rem;">${cliente.nombre}</span>
                            <span class="text-muted" style="font-size: 0.8rem;">DNI/CUIT: ${cliente.documento || cliente.dni}</span>
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
            doc.text(`Nro. Transacción: #${String(venta.id).padStart(5, '0')}`, 14, 28);
            doc.text(`Fecha y Hora: ${venta.fecha}`, 14, 34);
            doc.text(`Operador: ${venta.usuario_nombre}`, 14, 40);
            doc.text(`Forma de Pago: ${venta.forma_pago}`, 14, 46); 

            const filasTabla = venta.detalles.map(linea => [
                linea.nombre_item,
                linea.cantidad,
                `$${parseFloat(linea.precio_unitario).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`,
                `$${parseFloat(linea.subtotal).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`
            ]);

            doc.autoTable({
                startY: 52,
                head: [['Producto / Planta', 'Cantidad', 'Precio Unitario', 'Subtotal']],
                body: filasTabla,
                theme: 'striped',
                headStyles: { fillColor: [40, 167, 69] }
            });

            let finalY = doc.lastAutoTable.finalY + 12; 
            doc.setFontSize(12);
            doc.text("Descuento:", 140, finalY);
            doc.text(`$${parseFloat(venta.descuento).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`, 196, finalY, { align: 'right' });
            doc.text("Monto Total:", 140, finalY+6);
            doc.text(`$${parseFloat(venta.total).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`, 196, finalY+6, { align: 'right' });
            doc.save(`comprobante_venta_${venta.id}.pdf`);
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