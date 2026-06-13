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
                const id = document.getElementById("user-id").value;
                this.load(id)
                view.enableForm(false)
        });
        };

        const btnEliminar = document.querySelector(".btnEliminar");
        if(btnEliminar){
            btnEliminar.addEventListener("click", () =>{
                const id = document.getElementById("user-id").value;
                this.delete(id);
            })
        };

        const btnGuardar = document.querySelector(".btnGuardar");
        if(btnGuardar){
            btnGuardar.addEventListener("click", (e) =>{
                e.preventDefault();
                this.save();
            })
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
        const data = view.getFormData();

        if (data.contraseña !== data["contraseña2-data"]) {
        view.showMessage("Las contraseñas no coinciden", "error");
        return;
        }

        if(service.save(data)){
          view.showMessage("Registro creado!", "success");

          setTimeout(() => {
            window.location.href = "user/index";
          }, 1500);
        }
    },

    update: function(){
        const data = view.getFormData();
        console.log(data);
        if(service.update(data)){
            view.showMessage("Registro actualizado!", "success");
            document.getElementById("user-id").value = data.id;
            view.enableForm(false);
        }
    },

    delete: function(id){
        const user = service.load(id);
        
        if (service.delete(id)) {
        Swal.fire({
            title: "¡Registro eliminado!",
            html: `Se ha eliminado a: <b>${user.nombre}</b>`,
            showConfirmButton: false,
            icon: "warning",
            footer: '<a href="user/index">Volver al listado</a>' 
        });
            this.list(); 
        }
    },

    list: function(){
        const data = service.list()
        view.renderTable(data);        
    },

    exportToPDF: function(){
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const data = view.getFormData();

        const estado = document.getElementById("estado-data")?.textContent || "N/A";
        const fecha = document.getElementById("fecha-data")?.textContent || "N/A";

        doc.setFontSize(16);
        doc.text("Ficha de Usuario", 14, 20);

        doc.setFontSize(12);
        doc.text(`Nombre: ${data.nombre}`, 14, 40);
        doc.text(`Cuenta: ${data.cuenta}`, 14, 50);
        doc.text(`Correo: ${data.correo}`, 14, 60);
        doc.text(`Perfil: ${data.perfil === '1' ? 'Operador' : 'Administrador'}`, 14, 70);
        doc.text(estado, 14, 80);
        doc.text(fecha, 14, 90);

        doc.save(`usuario_${data.cuenta}.pdf`);
    },

    exportListToPDF: function(){
        if (!window.jspdf) {
        console.error("jsPDF no está cargado");
        return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.text("Listado de usuarios: ", 14, 20);

        doc.setFontSize(12);

        doc.autoTable({
            html:"#user-table",
            startY: 40,
            theme: 'striped',
            headStyles: { fillColor: [40, 167, 69]},
            columns: [0, 1, 2, 3]
        });

        doc.save("listado_usuarios.pdf");
    },
};