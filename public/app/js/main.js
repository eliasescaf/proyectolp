//Lógica del botón registro

const btnRegistro = document.querySelector(".btnGuardar");

if (btnRegistro) {
  btnRegistro.addEventListener("click", (e) => {
    e.preventDefault();
    Swal.fire({
      title: "Registro creado!",
      icon: "success",
      showConfirmButton: false,
      timer: 3000,
      allowOutsideClick: true,
      allowEscapeKey: true,
    });

    setTimeout(() => {
      e.target.closest("form").submit();
    }, 2000);
  });
}

// Lógica del botón eliminar
const btnEliminar = document.querySelector(".btnEliminar");

if (btnEliminar) {
  btnEliminar.addEventListener("click", () => {
    Swal.fire({
      title: "Registro eliminado!",
      icon: "error",
      showConfirmButton: false,
      timer: 3000,
      allowOutsideClick: true,
      allowEscapeKey: true,
    });
  });
}

// Cambios de estado de los botones

const btnEditar = document.querySelector(".btnEditar");
const formEdit = document.querySelector("#form-edit");
const btnActualizar = document.querySelector(".btnActualizar");
const btnCancelar = document.querySelector(".btnCancelar");
const campos = document.querySelectorAll("#form-edit input, #form-edit select");

const deshabilitarCamposYBtn = (estado) => {
    campos.forEach(campo => campo.disabled = estado);

    btnActualizar.disabled = estado;
    btnEditar.disabled = !estado;
    btnCancelar.disabled = estado;
}

btnEditar.addEventListener("click", () => {
  deshabilitarCamposYBtn(false); 
});

btnCancelar.addEventListener("click", () => {
  formEdit.reset();
  deshabilitarCamposYBtn(true);
});


//Lógica del botón actualizar
if (btnActualizar) {
  btnActualizar.addEventListener("click", (e) => {
    if (formEdit.checkValidity()) {
      e.preventDefault();

      deshabilitarCamposYBtn(true);

      Swal.fire({
        title: "Registro actualizado!",
        icon: "success",
        timer: 3000,
        allowOutsideClick: true,
        showConfirmButton: false,
      });

      setTimeout(() => {
      formEdit.submit();
    }, 2000);
    }
  });
}
