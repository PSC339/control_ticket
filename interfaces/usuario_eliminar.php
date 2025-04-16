<?php
    // se conecta a la bd.
    require '../config/conexion.php';
    // Obtengo el id del usuario.
    $id_usuario = $_GET['idusuario'];
    // var_dump($id_usuario);

    // print_r($_GET);
    // Aplico la instruccion de eliminado...
    // $sql_delete = "DELETE FROM db_tickets.tbl_usuario WHERE id_usuario = '$id_usuario'";
    $sql_delete = "UPDATE db_tickets.tbl_usuario SET is_active = 0 WHERE id_usuario = '$id_usuario'";
    mysqli_query($conn, $sql_delete);
    mysqli_close($conn);

    //Redirecciona a la pagina principal..
    header("location:usuario_mostrar.php");
