
<?php
require "../config/conexion.php";

// $valor_rec = $_POST;
// var_dump($valor_rec);

// insertar($conn);

// function insertar($conn){
    $var_rol = $_POST['sb_rol'];
    $var_nombre = $_POST['input_nombre'];
    $var_apellido = $_POST['input_apellido'];
    $var_usuario = $_POST['input_usuario'];
    $var_email = $_POST['input_email'];
    $var_pwd = $_POST['input_cntrasena'];
   
    $sql_agregar = "INSERT INTO db_tickets.tbl_usuario (id_rol, nombre, apellido, usuario, email, contrasena)
                 VALUES ('$var_rol','$var_nombre','$var_apellido','$var_usuario','$var_email','$var_pwd')";
    // var_dump($consulta);
    mysqli_query($conn,$sql_agregar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:usuario_mostrar.php");
// }

// eliminar($conn);

// function eliminar($conn){
//     $id_usuario = $_GET['idusuario'];
//     var_dump($id_usuario);

//     print_r($_GET);

//     $sql_delete = "DELETE FROM db_tickets.tbl_usuario WHERE id_usuario = '$id_usuario'";
//     mysqli_query($conn, $sql_delete);
//     mysqli_close($conn);
// }