<?php
    // se conecta a la bd.
    require '../config/conexion.php';
    // Obtengo el id del usuario.
    $id_rol = $_GET['idrol'];
    // var_dump($id_usuario);

    // print_r($_GET);
    // Aplico la instruccion de eliminado...
    // $sql_delete = "DELETE FROM db_tickets.tbl_rol WHERE id_usuario = '$id_rol'";
    $sql_delete = "UPDATE db_tickets.tbl_rol SET is_active = 0 WHERE id_rol='$id_rol';";
    mysqli_query($conn, $sql_delete);
    mysqli_close($conn);

    //Redirecciona a la pagina principal..
    header("location:rol_mostrar.php");
