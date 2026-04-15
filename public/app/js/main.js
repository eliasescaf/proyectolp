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

const btnEditar = document.querySelector(".btnEditar");
const formEdit = document.querySelector("#form-edit");
const btnActualizar = document.querySelector(".btnActualizar");
const btnCancelar = document.querySelector(".btnCancelar");
const campos = document.querySelectorAll("#form-edit input, #form-edit select");

btnEditar.addEventListener("click", () => {
  campos.forEach((campo) => {
    campo.disabled = false;
  });

  btnActualizar.disabled = false;
  btnCancelar.disabled = false;
  btnEditar.disabled = true;
});

btnCancelar.addEventListener("click", () => {
  formEdit.reset();

  campos.forEach((campo) => {
    campo.disabled = true;
  });

  btnActualizar.disabled = true;
  btnCancelar.disabled = true;
  btnEditar.disabled = false;
});

if (btnActualizar) {
  btnActualizar.addEventListener("click", (e) => {
    if (formEdit.checkValidity()) {
      e.preventDefault();

      Swal.fire({
        title: "Registro actualizado!",
        icon: "success",
        timer: 3000,
        allowOutsideClick: true,
        showConfirmButton: false,
      });
    }
    campos.forEach((campo) => (campo.disabled = true));

    btnActualizar.disabled = true;
    btnCancelar.disabled = true;
    btnEditar.disabled = false;

    setTimeout(() => {
      formEdit.submit();
    }, 2000);
  });
}
