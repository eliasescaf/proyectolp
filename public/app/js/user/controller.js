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
            btnActualizar.addEventListener("click", () => this.update())
        }

        const btnEditar = document.querySelector(".btnEditar");
        if(btnEditar){
            btnEditar.addEventListener("click", () => view.enableForm(true));
        }

        const btnCancelar = document.querySelector(".btnCancelar");
        if(btnCancelar){
            btnCancelar.addEventListener("click", () => {
                view.resetForm();
                view.enableForm(false)
        });
        }

        const btnEliminar = document.querySelector(".btnEliminar");
        if(btnEliminar){
            btnEliminar.addEventListener("click", () =>{
                const id = document.getElementById("user-id").value;
                this.delete(id);
            })
        }
        
    },

    load: function(id){
        const data = service.load(id);
        view.renderForm(data);
        view.enableForm(false);
    },

    save: function(){
        const data = view.getFormData();
        service.save(data);
        view.showMessage("Registro creado!", "success");
        view.resetForm();
    },

    update: function(){
        const data = view.getFormData();
        if(service.update(data)){
            view.showMessage("Registro actualizado!", "success");
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
            footer: '<a href="app/resources/views/user/index.html">Volver al listado</a>' 
        });
            this.list(); 
        }
    },

    list: function(){
        const data = service.list()
        view.renderTable(data);        
    },

    exportToPDF: function(){

    },
};