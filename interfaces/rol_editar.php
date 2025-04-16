<?php
require '../config/conexion.php';
	// $var_cargado = $_POST;
    // var_dump($var_cargado);
	$id_rol = $_POST['id_rol'];
	$varnombre = $_POST['input_nombre'];
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
	
	$sql_editar = "UPDATE db_tickets.tbl_rol SET nom_rol='$varnombre', editado = now() WHERE id_rol = '$id_rol'";
    //var_dump($sql_editar);
    mysqli_query($conn,$sql_editar);
    mysqli_close($conn);
    // Retorna pagina de cargado rol...
    header("location:rol_mostrar.php");