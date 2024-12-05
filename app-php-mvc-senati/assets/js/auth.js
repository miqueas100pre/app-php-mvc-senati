 async function login(event) {
    event.preventDefault();

    const nombreUsuario = document.getElementById('username').value;
    const claveUsuario = document.getElementById('password').value;
    // console.log(
    //     nombreUsuario,
    //     claveUsuario
    // );
    try {
        const respuesta = await fetch('auth/login',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                nombreUsuario, claveUsuario
            })
        });

        const respuestaJson = await respuesta.json(1);

        if(respuestaJson.status === 'error'){
            showAlertAuth('loginAlert','error',respuestaJson.message);
            return false;
        }

        // Redirecciona al salir todo bien(que el usuario este correcto) la pagina web
        window.location.href = 'http://localhost/app-php-mvc-senati/web';


    } catch (error) {
        showAlertAuth('loginAlert','error','Error al iniciar sesion'.error);
        return false;
    }
}

// function regist(event) {
//     event.preventDefault();

//     const nombreCompleto = document.getElementById('full_name').value;
//     const usuario = document.getElementById('username').value;
//     const correo = document.getElementById('email').value;
//     const claveRegistro = document.getElementById('password').value;
//     const claveConfirmanda = document.getElementById('confirm_password').value;

//     console.log(
//         nombreUsuario,
//         claveUsuario
//     );
// }
function showAlertAuth(containerId, type, message) {
    const container = document.getElementById(containerId);
    container.innerHTML = `
        <div class="alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}
