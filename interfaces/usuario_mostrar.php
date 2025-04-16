<?php
// confirmar sesion
session_start();
// if ($_SESSION['rol'] != 1) {
//     header('Location: ../index.html');
//     exit;
// }
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}
require "../login/verifica_permiso.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tickets</title>
        <meta charset="utf-8">
        <?php  ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/menu_vertical.css" />
        <link rel="stylesheet" href="../css/diseño_sitio.css">
        <link rel="stylesheet" href="../css/formulario.css">
        <link rel="stylesheet" href="../css/btn_tipo_alert.css">
        <link rel="stylesheet" href="../css/tabla.css" />
        <link rel="stylesheet" href="../css/menu_sesion.css" />
        <script src="../js/sweetalert2.all.js"></script>
        <script src="../js/alerta.js"></script>
    </head>
    <body>
        <?php
            require "../config/conexion.php";
            $regBuscar = '';
            $varBuscar = '';
             // Valido si el input viene null si es null le asigno un 0.
            $var_recibido = isset($_GET['idusuario']) ? $_GET['idusuario'] : '0';
            if ($var_recibido != 0) {
                $idusuario = $_GET['idusuario'];
                $sql = "SELECT tb1.id_usuario, tb2.rol, tb2.nom_rol, tb1.nombre, tb1.apellido, tb1.usuario, tb1.email, tb1.contrasena
                    FROM db_tickets.tbl_usuario tb1
                    LEFT JOIN db_tickets.tbl_rol tb2 ON tb1.id_rol = tb2.rol
                    WHERE tb1.id_usuario = '$idusuario'
                    AND tb1.is_active = 1;";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);

                // Consulta para obtener la categoría asociada al rol
                $sqlRol = "SELECT id_rol FROM db_tickets.tbl_rol WHERE id_rol = '$idusuario';";
                $resultRol = $conn->query($sqlRol);
                $rolSeleccionada = null;
                if ($resultRol->num_rows > 0) {
                    $rowRol = $resultRol->fetch_assoc();
                    $rolSeleccionada = $rowRol['id_rol']; // Guardamos el id de la categoría
                }
            }

            // Valido si el input viene null si es null le asigno un 0.
            $varBuscar = !empty($_GET['busqueda']) ? $_GET['busqueda'] : '0';
            if ($varBuscar != 0) {
                $regBuscar = $_GET['busqueda'];
            }

            // Consulta para obtener las catalogo roles.
            $sqlCatRoles = "SELECT * FROM db_tickets.tbl_rol WHERE is_active = 1;";
            $resultRoles = $conn->query($sqlCatRoles);
        ?>

        <div class="header">
            <div class="card_menu">
                <div class="btn_logout">
                    <div class="dropdown">
                        <button class="dropbtn">Usuario: <b><?= $_SESSION['name_user'] ?></b></button>
                        <div class="dropdown-content">
                            <a href="../login/cerrar_session.php">Salir</a>
                            <!-- <a href="#">Link 2</a> -->
                        </div>
                    </div>
                </div>
                <h2>Tickets</h2>
            </div>
        </div>

        <div class="row">
            <div class="column menu">
                <div class="card_menu">
                    <h4>Menu: <b><?= $_SESSION['rol'] ?></b></h4>
                    <hr>
                    <nav class="csMenu">
                    <input id="hMenuBtn" type="checkbox" />
                    <label for="hMenuBtn"></label>
                    <ul id="hMenu" class="mVerti">
                        <?php if($_SESSION['rol']=='Administrador') { ?>
                            <li><a href="usuario_mostrar.php" class="active">Usuarios</a></li>
                            <li><a href="rol_permiso_vista.php">Asignacion</a></li>
                            <li><a href="rol_mostrar.php">Roles</a></li>
                            <li><a href="permiso_mostrar.php">Permisos</a></li>
                            <li><a href="ticketsValidacion_vista.php">Técnicos</a></li>
                            <li><a href="ticketsCerrados_vista.php">Cerrados</a></li>
                            <li><a href="tickets_vista.php">Tickets</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['rol']=='Tecnico') { ?>
                            <li><a href="ticketsValidacion_vista.php">Técnicos</a></li>
                            <li><a href="ticketsCerrados_vista.php">Cerrados</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['rol']=='Empleado') { ?>
                            <li><a href="tickets_vista.php">Tickets</a></li>
                        <?php } ?>
                    </ul>
                    </nav>
                </div>
            </div>
    
            <div class="column formulario">
                <div class="card">
                    <?php if ($var_recibido == 0) { ?>
                        <h2>Nuevo Usuario</h2>
                    <hr>
                    <form action="usuario_agregar.php" method="POST">
                        <label for="input_nombre"><b>Nombre</b></label>
                        <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" required>
                        <label for="input_apellido"><b>Apellido</b></label>
                        <input type="text" placeholder="Ingresa apellido" name="input_apellido" id="input_apellido" required>
                        <label for="input_usuario"><b>Usuario</b></label>
                        <input type="text" placeholder="Ingresa usuario" name="input_usuario" id="input_usuario" required>
                        <label for="input_email"><b>Correo</b></label>
                        <input type="text" placeholder="Ingresa email" name="input_email" id="input_email" required>
                        <label for="input_cntrasena"><b>Contraseña</b></label>
                        <input type="password" placeholder="Ingresa contrasena" name="input_cntrasena" id="input_cntrasena" required>
                        <label for="sb_rol"><b>Rol</b></label>
                        <select name="sb_rol" id="sb_rol">
                        <option value="0">Elige una opcion...</option>
                            <?php
                            if ($resultRoles->num_rows > 0) {
                                // Mostrar los datos en el select box
                                while($rowRol = $resultRoles->fetch_assoc()) {
                                    echo '<option value="' . $rowRol["id_rol"] . '">' . $rowRol["nom_rol"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="clearfix">
                            <div class="row">
                                <div class="btn_cancel">
                                    <button type="reset" class="btn btn-danger btn-block">Cancelar</button>
                                </div>
                                
                                <div class="btn_agregar">
                                    <?php if (tiene_permiso('Agregar')) { ?>
                                    <button type="submit" class="btn btn-success btn-block">Agregar</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-success btn-block" onClick="permiso();">Agregar</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php } else { ?>
                    <h2>Modificar Usuario</h2>
                    <hr>
                    <form action="usuario_editar.php" method="POST">
                        <input type="hidden"  name="id_usuario" value="<?php echo $fila_id['id_usuario']; ?>" />
                        <label for="input_nombre"><b>Nombre</b></label>
                        <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" value="<?php echo $fila_id['nombre']; ?>" required>
                        <label for="input_apellido"><b>Apellido</b></label>
                        <input type="text" placeholder="Ingresa apellido" name="input_apellido" id="input_apellido" value="<?php echo $fila_id['apellido']; ?>" required>
                        <label for="input_usuario"><b>Usuario</b></label>
                        <input type="text" placeholder="Ingresa usuario" name="input_usuario" id="input_usuario" value="<?php echo $fila_id['usuario']; ?>" required>
                        <label for="input_email"><b>Correo</b></label>
                        <input type="text" placeholder="Ingresa email" name="input_email" id="input_email" value="<?php echo $fila_id['email']; ?>" required>
                        <label for="input_cntrasena"><b>Contrasena</b></label>
                        <input type="password" placeholder="Ingresa contrasena" name="input_cntrasena" id="input_cntrasena" value="<?php echo $fila_id['contrasena']; ?>" required>
                        <label for="input_rol"><b>Rol</b></label>
                        <select id="sb_rol" name="sb_rol">
                            <option value="0">Elige una opcion...</option>
                            <?php
                                if ($resultRoles->num_rows > 0) {
                                while ($catRol = $resultRoles->fetch_assoc()) {
                                    // Comprobar si esta categoría es la seleccionada
                                    $selected = ($catRol['id_rol'] == $rolSeleccionada) ? 'selected' : '';
                                    echo '<option value="' . $catRol['id_rol'] . '" ' . $selected . '>' . $catRol['nom_rol'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="clearfix">
                            <div class="row">
                                <div class="btn_cancel">
                                    <button type="reset" class="btn btn-danger btn-block">Cancelar</button>
                                </div>
                                <div class="btn_agregar">
                                    <button type="submit" class="btn btn-success btn-block">Editar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
    
            <div class="column vista">
                <div class="card">
                    <div class="titulo-lista">
                        <h2>Lista Usuarios</h2>
                    </div>
                    <div class="buscar-dato">
                        <form method="GET" action="usuario_mostrar.php" >
                            <div class="buscar-input">
                                <input type="text" name="busqueda" placeholder="Busqueda apellido..." title="Mostrar todos los registros campo vacio">
                            </div>
                            <div class="buscar-btn">
                                <button type="submit" class="btn btn-primary btn-block" >Buscar</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <?php
                        $sql = "SELECT tb1.id_usuario,tb2.nom_rol, tb1.nombre, tb1.apellido, tb1.usuario, tb1.email, tb1.contrasena
                        FROM db_tickets.tbl_usuario tb1
                        LEFT JOIN db_tickets.tbl_rol tb2 ON tb1.id_rol = tb2.id_rol
                        WHERE  IF('$varBuscar' = '', tb1.apellido = 0,tb1.apellido LIKE '%$regBuscar%')
                        AND tb1.is_active = 1;";
                        $result = $conn->query($sql);
                    ?>
                    <!--se despliega el resultado -->
                    <body>
                        <div style="overflow-x: auto;">
                            <table>  
                                <thead>
                                <tr>
                                <th scope='col'>Nombre</th>
                                <th scope='col'>Apellido</th>
                                <th scope='col'>Usuario</th>
                                <th scope='col'>Email</th>
                                <!-- <th scope='col'>Contrasena</th> -->
                                <th scope='col'>Rol</th> 
                                <th scope='col'>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                        <tr>
                                        <td><?php echo $fila['nombre']; ?></td>
                                        <td><?php echo $fila['apellido']; ?></td>
                                        <td><?php echo $fila['usuario']; ?></td>
                                        <td><?php echo $fila['email']; ?></td>
                                        <!-- <td><?php echo $fila['contrasena']; ?></td> -->
                                        <td><?php echo $fila['nom_rol']; ?></td>
                                        <td>
                                            <?php if (tiene_permiso('Modificar')) { ?>
                                                <a href="usuario_mostrar.php?idusuario=<?php echo $fila['id_usuario']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                            <?php } else { ?>
                                                <a onclick="permiso();"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                            <?php } ?>
                                            <?php if (tiene_permiso('Eliminar')) { ?>
                                                <a href="usuario_eliminar.php?idusuario=<?php echo $fila['id_usuario']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
                                            <?php } else { ?>
                                                <a onclick="permiso();"><img src="../img/trash_24.png" alt="modificar" title="Modificar"></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </body>
                </div>
            </div>
        </div>
    
    </body>
</html>