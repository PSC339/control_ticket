
<?php
require "../config/conexion.php";

$valor_rec = $_POST;
var_dump($valor_rec);

// insertar($conn);

// function insertar($conn){
    $var_rol = $_POST['input_rol'];
    $var_nombre = $_POST['input_nombre'];
   
    $sql_agregar = "INSERT INTO db_tickets.tbl_rol (rol, nom_rol) VALUES ('$var_rol','$var_nombre')";
    // var_dump($consulta);
    mysqli_query($conn,$sql_agregar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:rol_mostrar.php");
// }