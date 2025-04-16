<?php
require '../config/conexion.php';
	// $var_cargado = $_POST;
    // var_dump($var_cargado);
	session_start();

	// Se valida si se ha enviado información, con la función isset()
	if (!isset($_POST['input_username'], $_POST['input_pwd'])) {
		// si no hay datos muestra error y re direccionar
		header('Location: ../index.html');
	}

	// evitar inyección sql
	$sql_usuario = "SELECT u.id_usuario, u.usuario,u.contrasena, r.nom_rol AS rol
		FROM db_tickets.tbl_usuario u 
		INNER JOIN db_tickets.tbl_rol r ON u.id_rol = r.id_rol
		WHERE u.usuario = ?;";
	// var_dump($sql_usuario);

	if ($stmt = $conn->prepare($sql_usuario)) {
		// parámetros de enlace de la cadena s
		$stmt->bind_param('s', $_POST['input_username']);
		$stmt->execute();
	}

	// Aqui se valida si lo ingresado coincide con la base de datos
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($idusuario,$usuario, $contrasena, $rol);
		$stmt->fetch();
		// se confirma que la cuenta existe ahora validamos la contraseña
		if ($_POST['input_pwd'] === $contrasena) {

			// la conexion sería exitosa, se crea la sesión
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name_user'] = $_POST['input_username'];
			$_SESSION['usuario_id'] = $idusuario;
			$_SESSION['rol'] = $rol;
			//   var_dump($_SESSION);
			if ($_SESSION['rol'] == 'Administrador') {
				header('Location: ../interfaces/usuario_mostrar.php');
				// header('Location: ../interfaces/rol_mostrar.php');
			}
			if ($_SESSION['rol'] == 'Tecnico' ) {
				header('Location: ../interfaces/ticketsValidacion_vista.php');
				// header('Location: ../interfaces/rol_mostrar.php');
			}
			if ($_SESSION['rol'] == 'Empleado' ) {
				header('Location: ../interfaces/tickets_vista.php');
			}
			// header('Location: ../interfaces/usuario_mostrar.php');
		}
		else {
			// pwd incorrecto
			header('Location: ../index.html');
		}
	}
	else {
		// usuario incorrecto
		header('Location: ../index.html');
	}

$stmt->close();
