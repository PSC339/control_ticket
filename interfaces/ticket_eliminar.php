
<?php
    
    require "../config/conexion.php";
    // $varRecibido = $_GET;
    // var_dump($varRecibido);
    $var_idTicket = $_GET['idTicket'];
    // var_dump($var_idTicket);
    $var_activo = 0;
   
    $sqlDelete = "UPDATE db_tickets.tbl_tickets SET is_active = 0 WHERE id = '$var_idTicket';";
    // var_dump($sqlDelete);
    mysqli_query($conn,$sqlDelete);
    mysqli_close($conn);

    // $stmt = $conn->prepare($sqlDelete);
    // $stmt->bind_param("ii", $var_activo,$var_idTicket); // 'i' significa integer
    // $stmt->execute();

    // if ($stmt->affected_rows > 0) {
    //     echo "Registro eliminado exitosamente.";
    // } else {
    //     echo "No se encontró el registro o no se pudo eliminar.";
    // }

    // // Cerrar la conexión
    // $stmt->close();
    // $conn->close();
    // Retorna pagina de cargado usuario...
    header("location:tickets_vista.php");


