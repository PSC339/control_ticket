<?php
    // se conecta a la bd.
    require '../config/conexion.php';
    // Obtengo el id del usuario.
    $idRp = $_GET['idrp'];
    // var_dump($idPermiso);

    // Aplico la instruccion de eliminado...
    // $sql_delete = "DELETE FROM db_tickets.tbl_permiso WHERE id_permiso = '$idPermiso';";
    $sql_delete = "UPDATE db_tickets.tbl_roles_permisos SET is_active= 0, deleted = now() WHERE id_rp = '$idRp';";
    mysqli_query($conn, $sql_delete);
    mysqli_close($conn);

    //Redirecciona al modulo principal...
    header("location:rol_permiso_vista.php");
