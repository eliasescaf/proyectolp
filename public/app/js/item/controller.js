import { view } from "./view.js";
import { service } from "./service.js";

export const controller = {
    init: function(){
        this.list();
        this.bindEvents();
    },
    
    bindEvents: function(){
        const btnActualizar = document.querySelector(".btnActualizar");
        if(btnActualizar){
            btnActualizar.addEventListener("click", (e) => {
                e.preventDefault();
                this.update()})
        };

        const btnEditar = document.querySelector(".btnEditar");
        if(btnEditar){
            btnEditar.addEventListener("click", () => view.enableForm(true));
        };

        const btnCancelar = document.querySelector(".btnCancelar");
        if(btnCancelar){
            btnCancelar.addEventListener("click", () => {
                const id = document.getElementById("item-id").value;
                this.load(id)
                view.enableForm(false)
        });
        };

        const btnEliminar = document.querySelector(".btnEliminar");
        if(btnEliminar){
            btnEliminar.addEventListener("click", () =>{
                const id = document.getElementById("item-id").value;
                this.delete(id);
            })
        };

        const btnGuardar = document.querySelector(".btnGuardar");
        if(btnGuardar){
            btnGuardar.addEventListener("click", (e) =>{
                e.preventDefault();
                this.save();
            });
        };

        const btnPDF = document.querySelector(".btnPDF");
        if(btnPDF){
            btnPDF.addEventListener("click", () =>{
                this.exportToPDF();
            })
        };

        const btnListado = document.querySelector(".btnExportarListado");
        if(btnListado){
            btnListado.addEventListener("click", () =>{
                this.exportListToPDF();
            });
        };
        
    },

    load: function(id){
        const data = service.load(id);
        view.renderForm(data);
        view.enableForm(false);
    },

    save: function(){
        const form = document.getElementById("form-edit");
        if (!form) return;

        let data = Object.fromEntries(new FormData(form));
        
        data.categoria = parseInt(data.categoria);
        data.stock = parseInt(data.stock);
        data.precio = parseFloat(data.precio);
        
        console.info("Enviando producto parseado al servidor CoR:", data);

        service.saveRemote(data)
            .then(respuesta => {
                console.log("Respuesta del servidor:", respuesta);
                
                view.showMessage("¡Registro creado en base de datos!", "success");

                setTimeout(() => {
                    window.location.href = "item/index";
                }, 1500);
            })
            .catch(error => {
                console.error("Ha ocurrido un error en el flujo remito:", error);
                view.showMessage("Error al guardar en el servidor", "error");
            });
    },

    update: function(){
        const data = view.getFormData();
        console.log(data);
        if(service.update(data)){
            view.showMessage("Registro actualizado!", "success");
            document.getElementById("item-id").value = data.id;
            view.enableForm(false);
        }
    },

    delete: function(id){
        const item = service.load(id);
        
        if (service.delete(id)) {
        Swal.fire({
            title: "¡Registro eliminado!",
            html: `Se ha eliminado a: <b>${item.nombre}</b>`,
            showConfirmButton: false,
            icon: "warning",
            footer: '<a href="item/index">Volver al listado</a>' 
        });
            this.list(); 
        }
    },

    list: function(){
        const data = service.list();
        view.renderTable(data);        
    },

    exportToPDF: function(){
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const data = view.getFormData();

        const estado = document.getElementById("estado-data")?.textContent || "N/A";
        const fecha = document.getElementById("fecha-data")?.textContent || "N/A";

        const riegoTexto = data.riego === "1" ? "Bajo" : (data.riego === "2" ? "Medio" : "Alto");
        const catTexto = data.categoria === "1" ? "Interior" : (data.categoria === "2" ? "Exterior" : "Sombra");

        doc.setFontSize(16);
        doc.text("Ficha de Planta", 14, 20);

        doc.setFontSize(12);
        doc.text(`Nombre: ${data.nombre}`, 14, 32);
        doc.text(`Código: ${data.codigo || 'N/A'}`, 14, 40);
        doc.text(`Riego: ${riegoTexto}`, 14, 50);
        doc.text(`Descripcion: ${data.descripcion}`, 14, 60);
        doc.text(`Categoria: ${catTexto}`, 14, 70);
        doc.text(`Precio: ${data.precio}`, 14, 80);
        doc.text(`Stock: ${data.stock}`, 14, 90);
        doc.text(estado, 14, 100);
        doc.text(fecha, 14, 110);

        doc.save(`planta_${data.nombre}.pdf`);
    },

    exportListToPDF: function(){
        if (!window.jspdf) {
        console.error("jsPDF no está cargado");
        return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.text("Listado de plantas: ", 14, 20);

        doc.setFontSize(12);

        doc.autoTable({
            html:"#item-table",
            startY: 40,
            theme: 'striped',
            headStyles: { fillColor: [40, 167, 69]},
            columns: [0, 1, 2, 3, 4, 5, 6]
        });

        doc.save("listado_plantas.pdf");
    },
};