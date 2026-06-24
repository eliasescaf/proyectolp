import { view } from "./view.js";

export const controller = {
    init: function(){
        fetch("account/load")
            .then(result => result.json())
            .then(result =>{
                if(!result.success){
                    view.showMessage("No se pudieron cargar los datos de tu cuenta", "error");
                }
                view.renderForm(result.data);
            })
            .catch(e =>{
                console.error(e);
            })
        

        document.querySelector(".card-body")?.addEventListener("click", (e) => {
            if(e.target.closest(".btnEditar")){
                view.renderFormularioContraseña();
            }
        }),

        document.getElementById("contenedor-cambio-clave")?.addEventListener("click", (e) => {
            if(e.target.closest(".btnCancelarClave")){
                view.ocultarFormularioContraseña();
                return;
            }

            if(e.target.closest(".btnGuardarClave")){
                const passNueva = document.getElementById("pass-nueva").value;
                const passConfirmar = document.getElementById("pass-confirmar").value;
                
                if(!passNueva || !passConfirmar){
                    return view.showMessage("Por favor, complete todos los campos de seguridad.", "error");
                }

                if(passNueva !== passConfirmar){
                    return view.showMessage("La nueva contraseña y la confirmación no coinciden", "error");
                }

                fetch("account/updatePassword", {
                    method: "POST",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify({contrasenia: passNueva})
                }) 
                .then(result => result.json())
                .then(result => {
                    if(!result.success){ 
                        return view.showMessage(result.message, "error");
                    }
                    
                    view.showMessage("Contraseña cambiada", "success");
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                })
                .catch(err => {
                    console.error("Error en la petición:", err);
                    view.showMessage("No se pudo conectar con el servidor", "error");
                });
            }
        });
    }
};