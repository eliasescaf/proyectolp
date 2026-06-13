document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("login-form");
    form?.addEventListener("submit", async(e) => {
        e.preventDefault();
        const formData = new FormData(form);
        try{
            const response = await fetch("authentication/login", {
                method = "POST",
                body: formData
            });

            const result = await response.json();
            if(result.success){
                Swal.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "home/index";
                });
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: result.message,
                    confirmButtonColor: '#3085d6'
                });
            }
        }
        catch(error){
            console.error("Error en el fetch:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Intentá más tarde.',
            });
        }
    })
})