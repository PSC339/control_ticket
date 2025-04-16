
<?php
    require "../config/conexion.php";

    // $var_permiso = $_POST['sb_permiso'];
    $var_nombre = $_POST['input_nombre'];
   
    $sql_agregar = "INSERT INTO db_tickets.tbl_permiso (nom_permiso) VALUES ('$var_nombre')";
    // var_dump($consulta);
    mysqli_query($conn,$sql_agregar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:permiso_mostrar.php");