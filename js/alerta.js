function permiso_v(){
    alert("No cuenta con los permisos para ejecutar la accion...");
}

function permiso(){
        Swal.fire({
        icon: "error",
        title: "No cuenta con los permisos para ejecutar la accion...",
        text: "¡Favor de contactar el administrador del sistema!"
    });
}

function ticket(){
    Swal.fire({
    icon: "info",
    title: "Ticket",
    text: "En verificación"
});
}

function limpiar(){
    alert("Limpiando...");
}

function iniciado(){
    Swal.fire({
        icon: "info",
        title: "Ticket Iniciado",
        confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir a la URL deseada
            window.location.href = '../interfaces/validacion_tickets_vista.php?idTicket=<?php echo $fila["numero_tk"]; ?>;';
        }
    });
}

// // Tiempo de inactividad máximo (1 minuto)
// const tiempoInactividad = 60000; // 60000 ms = 1 minuto
// let temporizador;

// // Función que se ejecuta al detectar actividad
// function resetearSesion() {
//   clearTimeout(temporizador);
//   temporizador = setTimeout(cerrarSesion, tiempoInactividad);
// }

// // Función para cerrar sesión
// function cerrarSesion() {
//   //alert("La sesión ha terminado debido a inactividad.");
//   // Aquí podrías redirigir a otra página o cerrar sesión
//   // Por ejemplo:
//   window.location.href = "../login/cerrar_session.php"; // Redirige a una página de cierre de sesión
// }

// // Detectar eventos de actividad
// window.onload = resetearSesion; // Al cargar la página, inicializa el temporizador
// window.onmousemove = resetearSesion; // Movimiento del ratón
// window.onclick = resetearSesion; // Clic
// window.onkeypress = resetearSesion; // Teclado
// window.ontouchstart = resetearSesion; // Pantalla táctil (si es un dispositivo móvil)
