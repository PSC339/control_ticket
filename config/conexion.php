
<?php
    $server = "localhost";
    $user = "root";
    $pwd = "";
    $bd = "db_tickets";

    // Crear conexión
    $conn = new mysqli($server, $user, $pwd, $bd);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida - ERROR de conexión: " . $conn->connect_error);
    }
    //echo "Conexion OK";

?>