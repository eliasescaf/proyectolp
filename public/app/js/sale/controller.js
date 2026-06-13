import {service} from "./service.js";

let carrito = []; 
let totalGeneral = 0.0;

export const controller = {
    init: function(){
        const tableBody = document.getElementById("sales-table-body");
        if(tableBody){
            tableBody.addEventListener("click", (e) => {
                const btnDetalle = e.target.closest(".btnVerDetalle");
                if (btnDetalle){
                    const idVenta = btnDetalle.getAttribute("data-id");
                    this.mostrarDetalleModal(idVenta);
                    return;
                }

                const btnPdf = e.target.closest(".btnComprobantePDF");
                if(btnPdf){
                    const idVenta = btnPdf.getAttribute("data-id");
                    this.exportToPDF(idVenta);
                    return;
                }
            });

        };

        const btnPdfModal = document.querySelector(".btnImprimirTicketModal");
        if (btnPdfModal) {
            btnPdfModal.addEventListener("click", (e) => {
                const idVenta = btnPdfModal.getAttribute("data-id");
                
                if (idVenta) {
                    this.exportToPDF(idVenta);
                }
            });
        };

        const btnListado = document.querySelector(".btnExportarListado");
        if(btnListado){
            btnListado.addEventListener("click", () =>{
                this.exportListToPDF();
            });
        };

    },

    mostrarDetalleModal: function(id){
        const venta = service.getById(id);

        if(!venta){
            alert("No se encontró la transacción de prueba");
            return;
        }

        document.getElementById("modal-nro-venta").textContent = `#${String(venta.id).padStart(5, '0')}`;
        document.getElementById("modal-operador").textContent = venta.usuario_nombre;
        document.getElementById("modal-fecha").textContent = venta.fecha;
        document.getElementById("modal-total-venta").textContent = `$${venta.total.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;

        const detalleBody = document.getElementById("modal-detalle-body");
        detalleBody.innerHTML = ""; 

        venta.detalles.forEach(linea => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${linea.planta_nombre}</td>
                <td class="text-center">${linea.cantidad}</td>
                <td class="text-end">$${linea.precio_unitario.toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
                <td class="text-end fw-bold">$${linea.subtotal.toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
            `;
            detalleBody.appendChild(fila);
        });

        const btnDescargarModal = document.querySelector(".btnImprimirTicketModal");
        if (btnDescargarModal) {
            btnDescargarModal.setAttribute("data-id", venta.id);
        }

        const miModal = new bootstrap.Modal(document.getElementById('detalleVentaModal'));
        miModal.show();
    },

    exportToPDF: function(id){
        const venta = service.getById(id);

        if(!venta){
            alert("No se encontró una venta asociada al identificador");
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

        const filasTabla = venta.detalles.map(linea => [
            linea.planta_nombre,
            linea.cantidad,
            `$${linea.precio_unitario.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`,
            `$${linea.subtotal.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`
        ]);

        doc.autoTable({
            startY: 48,
            head: [['Producto / Planta', 'Cantidad', 'Precio Unitario', 'Subtotal']],
            body: filasTabla,
            theme: 'striped',
            headStyles: { fillColor: [40, 167, 69] }
        });

        let finalY = doc.lastAutoTable.finalY + 12; 

        doc.setFontSize(12);
        doc.text("Monto Total:", 140, finalY);
        doc.text(
            `$${venta.total.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`, 
            196, 
            finalY, 
            { align: 'right' }
        );
        doc.save(`comprobante_venta_${venta.id}.pdf`);
    },

    exportListToPDF: function(){
        if (!window.jspdf) {
        console.error("jsPDF no está cargado");
        return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.text("Listado de ventas: ", 14, 20);

        doc.setFontSize(12);

        doc.autoTable({
            html:"#sales-table",
            startY: 40,
            theme: 'striped',
            headStyles: { fillColor: [40, 167, 69]},
            columns: [0, 1, 2, 3]
        });

        doc.save("listado_ventas.pdf");
    },

    bindEventsCreate: function(){
        const selectProducto = document.getElementById("select-producto");
        const btnAgregar = document.getElementById("btn-agregar-carrito");
        const carritoBody = document.getElementById("carrito-body");
        const btnGuardar = document.getElementById("btn-guardar-venta");

        selectProducto?.addEventListener("change", () => {
            const option = selectProducto.options[selectProducto.selectedIndex];
            const precio = option.getAttribute("data-precio") || "0.00";
            document.getElementById("txt-precio-unitario").textContent = 
            `$${parseFloat(precio).toLocaleString("es-AR", {minimumFractionDigits: 2})}`;
        })

        btnAgregar?.addEventListener("click", () =>{
            if(selectProducto.value === "")return alert("Debe seleccionar un producto.");

            const inputCant = document.getElementById("input-cantidad");
            const option = selectProducto.options[selectProducto.selectedIndex];
            const idProducto = parseInt(selectProducto.value);
            const nombre = option.text.split(" (")[0];
            const precio = parseFloat(option.getAttribute("data-precio"));
            const stock = parseInt(option.getAttribute("data-stock"));
            const cantidad = parseInt(inputCant.value);

            if (cantidad<=0) return alert("La cantidad debe ser mayor a 0.");
            if (cantidad > stock) {
                return alert(`No hay stock suficiente. Máximo disponible: ${stock}`);
            }

            const indexExistente = carrito.findIndex(item => item.item_id === idProducto);
            if(indexExistente !== -1){
                if((carrito[indexExistente].cantidad + cantidad) > stock) return alert(`No podés agregar más de ese producto. Supera el stock de ${stockDisponible}`)

            carrito[indexExistente].cantidad += cantidad;
            carrito[indexExistente].subtotal = carrito[indexExistente].cantidad * precio;
            }
            else{
                carrito.push({ item_id: idProducto, nombre, cantidad, precio_unitario: precio, subtotal: cantidad * precio });
            }

            this.actualizarTablaInterfaz();

        });

        carritoBody?.addEventListener("click", (e) => {
            const btnBorrar = e.target.closest(".btnBorrarItem");
            if(btnBorrar) {
                const index = btnBorrar.getAttribute("data-index");
                carrito.splice(index, 1);
                this.actualizarTablaInterfaz();
            }
        });

        btnGuardar?.addEventListener("click", () => {
            const idUsuario = document.getElementById("select-usuario").value;
            if (idUsuario === "") return alert("Debe seleccionar un vendedor antes de confirmar.");
            if (carrito.length === 0) return alert("El detalle de la transacción está vacío.");

            const paqueteVenta = {
                usuario_id: parseInt(idUsuario),
                total: totalGeneral,
                productos: carrito
            };
        });
    },

    actualizarTablaInterfaz: function(){
        const tbody = document.getElementById("carrito-body");
        tbody.innerHTML= "";
        totalGeneral = 0.00;

        carrito.forEach((item, index) => {
            totalGeneral += item.subtotal;
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${item.nombre}</td>
                <td class="text-center">${item.cantidad}</td>
                <td class="text-end">$${item.precio_unitario.toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
                <td class="text-end fw-bold">$${item.subtotal.toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
                <td class="text-center">
                    <button class="btn btn-link link-danger p-0 btnBorrarItem" data-index="${index}"><i class="bi bi-trash"></i></button>
                </td>
            `;
            tbody.appendChild(fila);
        });
        document.getElementById("txt-total-general").textContent = `$${totalGeneral.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;
    }
}