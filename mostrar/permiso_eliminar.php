<?php
    // se conecta a la bd.
    require '../config/conexion.php';
    // Obtengo el id del usuario.
    $idPermiso = $_GET['idPermiso'];
    // var_dump($idPermiso);

    // print_r($_GET);
    // Aplico la instruccion de eliminado...
    // $sql_delete = "DELETE FROM db_tickets.tbl_permiso WHERE id_permiso = '$idPermiso';";
    $sql_delete = "UPDATE db_tickets.tbl_permiso SET is_active = 0 WHERE id_permiso='$idPermiso';";
    mysqli_query($conn, $sql_delete);
    mysqli_close($conn);

    //Redirecciona al modulo principal...
    header("location:permiso_mostrar.php");
