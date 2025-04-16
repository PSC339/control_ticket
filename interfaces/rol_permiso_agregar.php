
<?php
    require "../config/conexion.php";
    // $valor_rec = $_POST;
    // var_dump($valor_rec);

    $var_rol = $_POST['sb_rol'];
    $var_permiso= $_POST['sb_permiso'];
   
    $sql_agregar = "INSERT INTO db_tickets.tbl_roles_permisos (id_rol, id_permiso) VALUES ('$var_rol','$var_permiso')";
    // var_dump($consulta);
    mysqli_query($conn,$sql_agregar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:rol_permiso_vista.php");
