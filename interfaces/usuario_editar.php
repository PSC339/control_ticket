<?php
require '../config/conexion.php';
	// $var_cargado = $_POST;
    // var_dump($var_cargado);
	$id_usuario = $_POST['id_usuario'];
	$varrol = $_POST['input_rol'];
	$varnombre = $_POST['input_nombre'];
	$varapellido = $_POST['input_apellido'];
    $varusuario = $_POST['input_usuario'];
    $varemail = $_POST['input_email'];
    $varpwd = $_POST['input_cntrasena'];
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
	
	$sql_editar = "UPDATE db_tickets.tbl_usuario SET id_rol='$varrol', nombre='$varnombre', apellido='$varapellido', usuario='$varusuario', email='$varemail', contrasena='$varpwd' WHERE id_usuario = '$id_usuario'";
    //var_dump($sql_editar);
    mysqli_query($conn,$sql_editar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:usuario_mostrar.php");