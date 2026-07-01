document.addEventListener("DOMContentLoaded", () => {
    const formLogin = document.getElementById("login-form");
    formLogin?.addEventListener("submit", async(e) => {
        e.preventDefault();
        const formData = new FormData(formLogin);
        try {
            const response = await fetch("authentication/login", {
                method: "POST",
                body: formData
            });

            const result = await response.json();
            if(result.success){
                Swal.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500,
                    heightAuto: false
                }).then(() => {
                    window.location.href = "home/index";
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: result.message,
                    confirmButtonColor: '#3085d6',
                    heightAuto: false
                });
            }
        } catch(error) {
            console.error("Error en el fetch de login:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Intentá más tarde.',
                heightAuto: false
            });
        }
    });

    const btnLogout = document.getElementById("btn-logout");
    btnLogout?.addEventListener("click", async (e) => {
        e.preventDefault();
        try {
            const response = await fetch("authentication/logout", { method: "POST" });
            const result = await response.json();
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Adiós!',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500,
                    heightAuto: false
                }).then(() => {
                    window.location.href = "authentication/index";
                });
            }
        } catch (error) {
            console.error("Error al cerrar sesión:", error);
            window.location.href = "authentication/index";
        }
    });
});