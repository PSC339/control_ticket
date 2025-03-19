
<?php
require "../config/conexion.php";

$valor_rec = $_POST;
var_dump($valor_rec);

// insertar($conn);

// function insertar($conn){
    $var_permiso = $_POST['input_permiso'];
    $var_nombre = $_POST['input_nombre'];
   
    $sql_agregar = "INSERT INTO db_tickets.tbl_permiso (permiso, nom_permiso) VALUES ('$var_permiso','$var_nombre')";
    // var_dump($consulta);
    mysqli_query($conn,$sql_agregar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:permiso_mostrar.php");
// }