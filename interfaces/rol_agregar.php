
<?php
    require "../config/conexion.php";
    // $valor_rec = $_POST;
    // var_dump($valor_rec);
    // $var_rol = $_POST['input_rol'];
    $var_nombre = $_POST['input_nombre'];
   
    $sql_agregar = "INSERT INTO db_tickets.tbl_rol (nom_rol) VALUES ('$var_nombre')";
    // var_dump($consulta);
    mysqli_query($conn,$sql_agregar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:rol_mostrar.php");
