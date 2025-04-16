<?php
require '../config/conexion.php';
	$var_cargado = $_POST;
    var_dump($var_cargado);
	$idPermiso = $_POST['id_permiso'];
	// $varPermiso = $_POST['input_permiso'];
	$varNombre = $_POST['input_nombre'];
	// $estado_civil = $_POST['estado_civil'];
	// $hijos = isset($_POST['hijos']) ? $_POST['hijos'] : 0;
	// $intereses = isset($_POST['intereses']) ? $_POST['intereses'] : null;
	
	// $arrayIntereses = null;
	
	// $num_array = count($intereses);
	// $contador = 0;
	
	// if($num_array>0){
	// 	foreach ($intereses as $key => $value) {
	// 		if ($contador != $num_array-1)
	// 		$arrayIntereses .= $value.' ';
	// 		else
	// 		$arrayIntereses .= $value;
	// 		$contador++;
	// 	}
	// }
	
	$sql_editar = "UPDATE db_tickets.tbl_permiso SET nom_permiso='$varNombre', editado = now() WHERE id_permiso = '$idPermiso'";
    //var_dump($sql_editar);
    mysqli_query($conn,$sql_editar);
    mysqli_close($conn);
    // Retorna pagina de cargado rol...
    header("location:permiso_mostrar.php");