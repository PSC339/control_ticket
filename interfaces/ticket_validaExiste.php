
<?php
    
    require "../config/conexion.php";

    $sql = "SELECT numero_tk,
        CASE WHEN iniciado IS NULL THEN 'No iniciado'
        -- WHEN iniciado > CURDATE() THEN 'No iniciado'
        WHEN iniciado IS NOT NULL AND finalizado IS NULL THEN 'En verificacion'
        WHEN finalizado IS NOT NULL THEN 'Finalizado'
    ELSE 'Desconocido'
    END AS estatus, iniciado, finalizado
    FROM db_tickets.tbl_subtickets
    WHERE is_active = 1;";

    $resultado = $conn->query($sql);

    while ($row = $resultado->fetch_assoc()) {
        echo "Proyecto: " . $row['numero_tk'] . " - Estatus: " . $row['estatus'] . "<br>";
    }


    // $varRecibido = $_GET;
    // var_dump($varRecibido);
    // $var_numero_tk = $_GET['numTicket'];
    // var_dump($var_numero_tk);

    // function existe($valida) {
    //     global $conn;
    //     $sqlNumero = "SELECT count(numero_tk) num_tk FROM db_tickets.tbl_subtickets where numero_tk = '$valida';";
    //     $resNumero = $conn->query($sqlNumero);
    //     $rowNumero = $resNumero->fetch_array(MYSQLI_ASSOC);
    //     $numero = $rowNumero['num_tk'];
    //     // mysqli_close($conn);
    // }
        
// // Función para verificar si un correo electrónico ya existe en la base de datos
// function checkNumero($numero) {
//     global $conn;
//     // Consulta SQL para verificar si el correo ya está registrado
//     $sql = "SELECT count(numero_tk) num_tk FROM db_tickets.tbl_subtickets where numero_tk = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("s", $num_tk); // "s" indica que el parámetro es una cadena (string)
    
//     $stmt->execute();
//     $result = $stmt->get_result();
    
//     // Verificar si el correo existe en la base de datos
//     if ($result->num_rows > 0) {
//         return true; // El correo ya está registrado
//     } else {
//         return false; // El correo no está registrado
//     }

//     // Cerrar la conexión
//     $stmt->close();
//     $conn->close();
// }

// // Función para verificar permisos
// function tiene_permiso($existe) {
//     global $conn;

//     // if (!isset($_SESSION['usuario_id'])) {
//     //     return false;  // No está logueado
//     // }

//     // $usuario_id = $_SESSION['usuario_id'];
    
//     // Verificar si el usuario tiene el permiso específico
//     $query = "SELECT p.nom_permiso FROM db_tickets.tbl_permiso p 
//                 INNER JOIN db_tickets.tbl_roles_permisos rp ON p.id_permiso = rp.id_permiso
//                 INNER JOIN db_tickets.tbl_usuario u ON u.id_rol = rp.id_rol
//                 WHERE u.id_usuario = ? AND p.nom_permiso = ?;";
//     // var_dump($query);

//     $stmt = $conn->prepare($query);
//     $stmt->bind_param('s', $existe);
//     $stmt->execute();
//     $resultado = $stmt->get_result();
    
//     return $resultado->num_rows > 0;
// }

