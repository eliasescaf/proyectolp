export const view = {
    getTablaBody: () => document.getElementById("sales-table-body"),

    renderTable: function(ventas) {

        const tbody = this.getTablaBody();
        if (!tbody) return;
        
        tbody.innerHTML = "";

        if (ventas.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-3 small">
                        No se encontraron transacciones registradas en el historial
                    </td>
                </tr>`;
            return;
        }

        let htmlRows = ""; 

        ventas.forEach(venta => {
            const nroFactura = `#${String(venta.numero_venta).padStart(5, '0')}`;
            const totalFormateado = parseFloat(venta.total).toLocaleString('es-AR', { minimumFractionDigits: 2 });

            htmlRows += `
                <tr>
                    <td class="fw-medium text-dark">${nroFactura}</td>
                    <td>${venta.fecha}</td>
                    <td>${venta.usuario_nombre || 'Operador'}</td>
                    <td class="fw-bold text-dark">$${totalFormateado}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-secondary btnVerDetalle" data-id="${venta.id}" title="Ver Renglones">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger btnComprobantePDF" data-id="${venta.id}" title="Exportar PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = htmlRows;
    },

    renderCarrito: function(carrito) {
        const tbody = document.getElementById("carrito-body");
        if (!tbody) return;

        tbody.innerHTML = "";
        let totalGeneral = 0.00;

        carrito.forEach((item, index) => {
            totalGeneral += item.subtotal;
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${item.nombre}</td>
                <td class="text-center">
                    <input 
                        type="number" 
                        class="form-control form-control-sm text-center cambiar-cant carrito-render" 
                        value="${item.cantidad}" 
                        min="1" 
                        max="${item.stock}" 
                        data-id="${item.item_id}">
                </td>
                <td class="text-end">$${item.precio_unitario.toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
                <td class="text-end fw-bold">$${item.subtotal.toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
                <td class="text-center">
                    <button class="btn btn-link link-danger p-0 btnBorrarItem" data-id="${item.item_id}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(fila);
        });

        document.getElementById("txt-total-general").textContent = 
            `$${totalGeneral.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;
        
        return totalGeneral;
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

    

    mostrarDetalleModal: function(venta) {
        document.getElementById("modal-nro-venta").textContent = `#${String(venta.numero_venta).padStart(5, '0')}`;
        document.getElementById("modal-operador").textContent = venta.usuario_nombre;
        document.getElementById("modal-fecha").textContent = venta.fecha;
        document.getElementById("modal-total-venta").textContent = `$${parseFloat(venta.total).toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;
        document.getElementById("modal-cliente").textContent = venta.cliente_nombre || "Consumidor Final";
        document.getElementById("modal-forma-pago").textContent = venta.forma_pago || "No especificada";

        const descuentoValue = parseFloat(venta.descuento) || 0;
        const contenedorDescuento = document.getElementById("modal-descuento-venta");
        
        if (descuentoValue > 0) {
            contenedorDescuento.textContent = `-$${descuentoValue.toLocaleString('es-AR', { minimumFractionDigits: 2 })}`;
        } else {
            contenedorDescuento.textContent = "$0,00";
        }

        const detalleBody = document.getElementById("modal-detalle-body");
        detalleBody.innerHTML = ""; 

        venta.detalles.forEach(linea => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
                <td>${linea.nombre_item}</td>
                <td class="text-center">${linea.cantidad}</td>
                <td class="text-end">$${parseFloat(linea.precio_unitario).toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
                <td class="text-end fw-bold">$${parseFloat(linea.subtotal).toLocaleString('es-AR', { minimumFractionDigits: 2 })}</td>
            `;
            detalleBody.appendChild(fila);
        });

        document.querySelector(".btnImprimirTicketModal")?.setAttribute("data-id", venta.id);

        const miModal = new bootstrap.Modal(document.getElementById('detalleVentaModal'));
        miModal.show();
    },

    renderPaginador: function(meta, cambiarPagina){
        const contenedorText = document.getElementById("txt-mostrando-paginas");
        const paginadorUl = document.getElementById("ul-paginacion");

        if(!paginadorUl) return;

        const desde = (meta.current_page - 1) * meta.limit + 1;
        const hasta = Math.min(meta.current_page * meta.limit, meta.total_records);

        if(contenedorText){
            contenedorText.innerHTML = meta.total_records > 0 
                ? `Mostrando <span class="fw-bold">${desde}</span> a <span class="fw-bold">${hasta}</span> de <span class="fw-bold">${meta.total_records}</span> ventas`
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