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
            //print_r($_GET);
            $var_recibido = isset($_GET['idrol']) ? $_GET['idrol'] : '0';

            if ($var_recibido != 0) {
                # code...
                $idrol = $_GET['idrol'];
                $sql = "SELECT * FROM db_tickets.tbl_rol WHERE id_rol = '$idrol'";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);
            }

            // Valido si el input viene null si es null le asigno un 0.
            $varBuscar = !empty($_GET['busqueda']) ? $_GET['busqueda'] : '0';
            if ($varBuscar != 0) {
                $regBuscar = $_GET['busqueda'];
                // var_dump("Nombre recibido: ".$regBuscar);
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
                                <li><a href="usuario_mostrar.php">Usuarios</a></li>
                                <li><a href="rol_permiso_vista.php">Asignacion</a></li>
                                <li><a href="rol_mostrar.php" class="active">Roles</a></li>
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
                                <!-- <li><a href="#">Técnico</a></li> -->
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
    
            <div class="column formulario">
                <!-- <div class="row"> -->
                        <div class="card">
                            <?php if ($var_recibido == 0) { ?>
                                <h2>Nuevo Rol</h2>
                            <hr>
                            <form action="rol_agregar.php" method="POST">
                                <label for="input_nombre"><b>Nombre</b></label>
                                <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" required>
                                <div class="clearfix">
                                    <div class="row">
                                        <div class="btn_cancel">
                                            <button type="reset" class="btn btn-danger btn-block">Cancelar</button>
                                        </div class="row">
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
                            <h2>Modificar   Rol</h2>
                            <hr>
                            <form action="rol_editar.php" method="POST">
                                <!-- <label for="input_rol"><b>Nivel</b></label>
                                <input type="text" placeholder="Ingresa rol" name="input_rol" id="input_rol" value="<?php echo $fila_id['rol']; ?>" required> -->
                                <label for="input_nombre"><b>Nombre</b></label>
                                <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" value="<?php echo $fila_id['nom_rol']; ?>" required>
                                <input type="hidden"  name="id_rol" value="<?php echo $fila_id['id_rol']; ?>" />
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
                <!-- </div> -->
            </div>
    
            <div class="column vista">
                <div class="card">
                    <h2 class="titulo-lista">Lista Catalogo Roles</h2>
                    <div class="buscar-dato">
                        <form method="GET" action="rol_mostrar.php" >
                            <div class="buscar-input">
                                <input type="text" name="busqueda" placeholder="Busqueda rol..." title="Mostrar todos los registros campo vacio">
                            </div>
                            <div class="buscar-btn">
                                <button type="submit" class="btn btn-primary btn-block" >Buscar</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <?php
                    $sql = "SELECT * FROM db_tickets.tbl_rol
                    WHERE IF('$varBuscar' = '', nom_rol = 0, nom_rol LIKE '%$regBuscar%')
                    AND is_active=1;";
                    $result = $conn->query($sql);
                    // var_dump($sql);
                    ?>
                    <!--se despliega el resultado -->
                    <body>
                        <div style="overflow-x: auto;">
                            <table>  
                                <thead>
                                <tr>
                                <th scope='col'>Nombre</th> 
                                <th scope='col'>Creado</th>
                                <th scope='col'>Editado</th>
                                <th scope='col'><center>Accion</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = $result->fetch_assoc()) { ?>
                                        <tr>
                                        <td><?php echo $fila['nom_rol']; ?></td>
                                        <td><?php echo $fila['created_at']; ?></td>
                                        <td><?php echo $fila['editado']; ?></td>
                                        <td>
                                            <center>
                                                <?php if (tiene_permiso('Modificar')) { ?>
                                                    <a href="rol_mostrar.php?idrol=<?php echo $fila['id_rol']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                                <?php } else { ?>
                                                    <a onclick="permiso();"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                                <?php } ?>
                                                <?php if (tiene_permiso('Eliminar')) { ?>
                                                    <a href="rol_eliminar.php?idrol=<?php echo $fila['id_rol']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
                                                <?php } else { ?>
                                                    <a onclick="permiso();"><img src="../img/trash_24.png" alt="modificar" title="Modificar"></a>
                                                <?php } ?>
                                            </center>
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

<?php
// }
// else{
//     header('Location: ../index.html');
//     exit;
// }
?>