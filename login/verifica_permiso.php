<?php
    require '../config/conexion.php';
    //session_start();

    // Función para verificar permisos
    function tiene_permiso($permiso) {
        global $conn;

        if (!isset($_SESSION['usuario_id'])) {
            return false;  // No está logueado
        }

        $usuario_id = $_SESSION['usuario_id'];
        
        // Verificar si el usuario tiene el permiso específico
        $query = "SELECT p.nom_permiso FROM db_tickets.tbl_permiso p 
                    INNER JOIN db_tickets.tbl_roles_permisos rp ON p.id_permiso = rp.id_permiso
                    INNER JOIN db_tickets.tbl_usuario u ON u.id_rol = rp.id_rol
                    WHERE u.id_usuario = ? AND p.nom_permiso = ?;";
        // var_dump($query);

        $stmt = $conn->prepare($query);
        $stmt->bind_param('is', $usuario_id, $permiso);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->num_rows > 0;
    }

// Obtener el permiso desde la URL
// if (isset($_GET['permiso'])) {
//     $permiso = $_GET['permiso'];

//     // Verificar si tiene el permiso
//     if (tiene_permiso($permiso)) {
//         echo "Tienes permiso para: " . htmlspecialchars($permiso);
//     } else {
//         echo "No tienes permiso para: " . htmlspecialchars($permiso);
//     }
// } else {
//     echo "No se proporcionó un permiso válido en la URL.";
// }

?>
	