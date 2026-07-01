import { view } from "./view.js";
import { service } from "./service.js";

let paginaActual = 1;
let filtrosActuales = {
    buscar: "",
    perfil: ""
};

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

        document.getElementById("btn-filtrar-usuarios")?.addEventListener("click", () => {
            filtrosActuales.buscar = document.getElementById("filtro-buscar-usuario").value.trim();
            filtrosActuales.perfil = document.getElementById("filtro-perfil-usuario").value;
            paginaActual = 1;
            this.list();
        });

        document.getElementById("btn-limpiar-usuarios")?.addEventListener("click", () => {
            filtrosActuales.buscar = "";
            filtrosActuales.perfil = "";
            paginaActual = 1;

            const inputBuscar = document.getElementById("filtro-buscar-usuario");
            const selectPerfil = document.getElementById("filtro-perfil-usuario");
            if (inputBuscar) inputBuscar.value = "";
            if (selectPerfil) selectPerfil.value = "";

            this.list();
        });
        
    },

    load: function(id){
        service.load(id).then(data => {
            if(data){
                view.renderForm(data);
            }
            else{
                view.showMessage("Error al cargar usuario", "error");
            }
        })
    },

    save: function(){
        const data = view.getFormData();
        if(data.contraseña !== data["contraseña2-data"]){
            view.showMessage("Las contraseñas no coinciden", "error");
            return;
        }
        service.save(data).then(result => {
            if(result.success){
                view.showMessage("Registro guardado", "success");
                setTimeout(() => {
                    window.location.href = "user/index";
                }, 1500);
            } else {
                view.showMessage(result.message, "error");
            }
        })
    },

    update: function(){
        const data = view.getFormData();
        console.log("Datos reales que viajan al backend:", JSON.stringify(data, null, 2));
        service.update(data).then(result => {
            if(result.success){
                view.showMessage("Registro actualizado", "success");
                setTimeout(() => {
                    window.location.href = "user/index";
                }, 1500);
            } else {
                view.showMessage(result.message, "error");
            }
        })
    },

    delete: function(id){
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            confirmButtonColor: "#dc3545",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#636366"
        }).then((result) => {
            if(result.isConfirmed){
                service.delete(id).then(response => {
                    if (response.success) {
                        view.showMessage("Registro eliminado", "success");
                        setTimeout(() => {
                            window.location.href = "user/index";
                        }, 1500);
                    } else {
                        Swal.fire({
                            title: "Acción Bloqueada",
                            text: response.message, 
                            icon: "info", 
                            confirmButtonColor: "#1c1c1e"
                        });
                    }
                });
            }
        });
    },

    list: function(){
        const parametros = {
            page: paginaActual,
            limit: 10,
            buscar: filtrosActuales.buscar,
            perfil: filtrosActuales.perfil
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

        }).catch(err => {
            console.error("Hubo un problema al listar usuarios", err);
        });
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

        const hoy = new Date();
        const fechaFormateada = hoy.toLocaleDateString("es-AR");
        doc.setFontSize(10);
        doc.text(`Fecha de emisión: ${fechaFormateada}`, 14, 26);

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