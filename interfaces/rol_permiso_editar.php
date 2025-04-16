<?php
require '../config/conexion.php';

	$var_id = $_POST['id_rp'];
	$var_rol = $_POST['sb_rol'];
	$var_permiso = $_POST['sb_permiso'];
	
	$sql_editar = "UPDATE db_tickets.tbl_roles_permisos SET id_rol='$var_rol', id_permiso='$var_permiso', editado = now() WHERE id_rp = '$var_id';";
    //var_dump($sql_editar);
    mysqli_query($conn,$sql_editar);
    mysqli_close($conn);
    // Retorna pagina de cargado rol...
    header("location:rol_permiso_vista.php");