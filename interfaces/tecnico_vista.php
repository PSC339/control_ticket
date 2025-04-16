<?php
// confirmar sesion
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}

require "../login/verifica_permiso.php";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Técnicos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/menu_vertical.css" />
        <link rel="stylesheet" href="../css/diseño_sitio.css">
        <link rel="stylesheet" href="../css/formulario.css">
        <link rel="stylesheet" href="../css/btn_tipo_alert.css">
        <link rel="stylesheet" href="../css/tabla.css" />
        <link rel="stylesheet" href="../css/menu_sesion.css" />
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.16.1/sweetalert2.all.js"></script> -->
        <script src="../js/sweetalert2.all.js"></script>
        <script src="../js/alerta.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <?php
            require "../config/conexion.php";
            $idBusca = '';
            //print_r($_GET);
            $var_recibido = isset($_GET['idusuario']) ? $_GET['idusuario'] : '0';

            if ($var_recibido != 0) {
                # code...
                $idusuario = $_GET['idusuario'];
                $sql = "SELECT * FROM db_tickets.tbl_usuario WHERE id_usuario = '$idusuario'";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);
            }

            // Valido si el input viene null si es null le asigno un 0.
            $varBuscar = isset($_GET['busqueda']) ? $_GET['busqueda'] : '0';
            if ($varBuscar != 0) {
                $idBusca = $_GET['busqueda'];
                // var_dump("Nombre recibido: ".$idBusca);
            }
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
                <h2>Técnico</h2>
            </div>
        </div>

        <div class="row">
            <div class="column menu">
                <div class="card_menu">
                    <h2>Panel</h2>
                    <hr>
                    <nav class="csMenu">
                    <input id="hMenuBtn" type="checkbox" />
                    <label for="hMenuBtn"></label>
                    <ul id="hMenu" class="mVerti">
                        <?php if($_SESSION['rol']=='Administrador') { ?>
                                <li><a href="usuario_mostrar.php">Usuarios</a></li>
                                <li><a href="rol_permiso_vista.php">Asignacion</a></li>
                                <li><a href="rol_mostrar.php">Roles</a></li>
                                <li><a href="permiso_mostrar.php">Permisos</a></li>
                                <li><a href="tecnico_vista.php" class="active">Técnicos</a></li>
                                <li><a href="tickets_vista.php">Tickets</a></li>
                            <?php } ?>
                            <?php if ($_SESSION['rol']=='Tecnico') { ?>
                                <li><a href="tecnico_vista.php" class="active">Técnicos</a></li>
                            <?php } ?>
                            <?php if ($_SESSION['rol']=='Empleado') { ?>
                                <li><a href="tickets_vista.php">Tickets</a></li>
                                <!-- <li><a href="#">Técnico</a></li> -->
                            <?php } ?>
                    </ul>
                    </nav>
                </div>
            </div>
    
            <div class="column formulario">
                <div class="card">
                    <?php if ($var_recibido == 0) { ?>
                        <h2>Nuevo Técnico</h2>
                        <hr>
                        <form action="ticket_agregar.php" method="POST">
                            <label for="input_depto"><b>Nombre</b></label>
                            <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" required>
                            <label for="input_apellido"><b>Apellido</b></label>
                            <input type="text" placeholder="Ingresa depto" name="input_depto" id="input_depto" required>
                            <div class="clearfix">
                                <div class="row">
                                    <div class="btn_cancel">
                                        <button type="reset" class="btn btn-danger btn-block">Cancelar</button>
                                    </div>
                                    <div class="btn_agregar">
                                        <?php if (tiene_permiso('Agregar')) { ?>
                                            <button type="submit" class="btn btn-success btn-block">Agregar</button>
                                        <?php } else { ?>
                                            <button type="button" id="boton" class="btn btn-success btn-block" onClick="permiso();">Agregar NO</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                    <h2>Modificar Técnico</h2>
                    <hr>
                    <form action="usuario_editar.php" method="POST">
                        <label for="input_rol"><b>Rol</b></label>
                        <input type="text" placeholder="Ingresa rol" name="input_rol" id="input_rol" value="<?php echo $fila_id['id_rol']; ?>" required>
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
                        <input type="text" placeholder="Ingresa contrasena" name="input_cntrasena" id="input_cntrasena" value="<?php echo $fila_id['contrasena']; ?>" required>
                        <div class="clearfix">
                            <div>
                                <div class="btn_cancel">
                                    <button type="reset" class="btn btn-danger btn-block">Cancelar</button>
                                </div>
                                <div class="btn_agregar">
                                    <button type="submit" class="btn btn-success btn-block">Editar</button>
                                </div>.
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
    
            <div class="column vista">
                <div class="card">
                    <h2 class="titulo-lista">Lista Técnicos</h2>
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
                    $sql = "SELECT * FROM db_tickets.tbl_lista_tickets;";
                    $result = $conn->query($sql);
                    //var_dump($result);
                    ?>
                    <!--se despliega el resultado -->
                    <body>
                        <div style="overflow-x: auto;">
                            <table>  
                                <thead>
                                <tr>
                                <!-- <th scope='col'>Rol</th>  -->
                                <th scope='col'>Nombre</th>
                                <th scope='col'>Depto</th>
                                <!-- <th scope='col'>Usuario</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Contrasena</th>  -->
                                <th scope='col'>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = $result->fetch_assoc()) { ?>
                                        <tr>
                                        <!-- <td><?php echo $fila['id_rol']; ?></td> -->
                                        <td><?php echo $fila['nombre']; ?></td>
                                        <td><?php echo $fila['depto']; ?></td>
                                        <!-- <td><?php echo $fila['usuario']; ?></td>
                                        <td><?php echo $fila['email']; ?></td>
                                        <td><?php echo $fila['contrasena']; ?></td> -->
                                        <!-- <td><button class='btn_tb success btn-block'><a href="mostrar_user.php?idusuario=<?php echo $fila['id_usuario']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a></button></td> -->
                                        <td>
                                            <?php if (tiene_permiso('Editar')) { ?>
                                                <a href="usuario_mostrar.php?idusuario=<?php echo $fila['id']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                            <?php } else { ?>
                                                <a onclick="permiso();"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                            <?php } ?>
                                            <?php if (tiene_permiso('Editar')) { ?>
                                                <a href="usuario_eliminar.php?idusuario=<?php echo $fila['id']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
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

