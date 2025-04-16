<?php
// confirmar sesion
session_start();
// if ($_SESSION['rol'] == 2) {
//     var_dump($rol);
   
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
            $var_recibido = isset($_GET['idrp']) ? $_GET['idrp'] : '0';

            if ($var_recibido != 0) {
                # code...
                $idrp = $_GET['idrp'];
                $sql = "SELECT id_rp FROM db_tickets.tbl_roles_permisos WHERE id_rp = '$idrp';";
                $res_rp = $conn->query($sql);
                $fila_id = $res_rp->fetch_array(MYSQLI_ASSOC);

                // Consulta para obtener la categoría asociada al producto
                $sqlRol = "SELECT id_rol FROM db_tickets.tbl_roles_permisos WHERE id_rp = '$idrp';";
                $resultRol = $conn->query($sqlRol);
                $rolSeleccionada = null;
                if ($resultRol->num_rows > 0) {
                    $rowRol = $resultRol->fetch_assoc();
                    $rolSeleccionada = $rowRol['id_rol']; // Guardamos el id de la categoría
                }

                $sqlPermiso = "SELECT id_permiso FROM db_tickets.tbl_roles_permisos WHERE id_rp = '$idrp';";
                $resultPer = $conn->query($sqlPermiso);
                $perSeleccionada = null;
                if ($resultPer->num_rows > 0) {
                    $rowPer = $resultPer->fetch_assoc();
                    $perSeleccionada = $rowPer['id_permiso']; // Guardamos el id de la categoría
                }
            }

            // Consulta para obtener las catalogo roles.
            $sqlCatRoles = "SELECT * FROM db_tickets.tbl_rol WHERE is_active = 1;";
            $resultRoles = $conn->query($sqlCatRoles);
            // Consulta para obtener catalog permiso.
            $sqlCatPer = "SELECT * FROM db_tickets.tbl_permiso WHERE is_active = 1;";
            $resultPermisos = $conn->query($sqlCatPer);

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
                                <li><a href="rol_permiso_vista.php" class="active">Asignacion</a></li>
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
                                <h2>Nuevo Asignacion</h2>
                            <hr>
                            <form action="rol_permiso_agregar.php" method="POST">
                                <label for="sb_rol"><b>Rol:</b></label>
                                <select name="sb_rol" id="sb_rol">
                                    <option value="0">Elige una opción...</option>
                                    <?php
                                    if ($resultRoles->num_rows > 0) {
                                        // Mostrar los datos en el select box
                                        while($rowRol = $resultRoles->fetch_assoc()) {
                                            echo '<option value="' . $rowRol["id_rol"] . '">' . $rowRol["nom_rol"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="sb_permiso"><b>Permiso</b></label>
                                <select name="sb_permiso" id="sb_permiso">
                                    <option value="0">Elige una opción...</option>
                                    <?php
                                    if ($resultPermisos->num_rows > 0) {
                                        // Mostrar los datos en el select box
                                        while($rowPermiso = $resultPermisos->fetch_assoc()) {
                                            echo '<option value="' . $rowPermiso["id_permiso"] . '">' . $rowPermiso["nom_permiso"] . '</option>';
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
                            <h2>Modificar Asignación</h2>
                            <hr>
                            <form action="rol_permiso_editar.php" method="POST">
                                <label for="sb_rol"><b>Rol</b></label>
                                <select id="sb_rol" name="sb_rol">
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
                                <input type="hidden"  name="id_rp" value="<?php echo $fila_id['id_rp']; ?>" />
                                <label for="sb_permiso"><b>Permiso</b></label>
                                <select name="sb_permiso" id="sb_permiso">
                                    <?php
                                        while ($catPermiso = $resultPermisos->fetch_assoc()) {
                                            // Comprobar si esta categoría es la seleccionada
                                            $selected = ($catPermiso['id_permiso'] == $perSeleccionada) ? 'selected' : '';
                                            echo '<option value="' . $catPermiso['id_permiso'] . '" ' . $selected . '>' . $catPermiso['nom_permiso'] . '</option>';
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
                <!-- </div> -->
            </div>
    
            <div class="column vista">
                <div class="card">
                    <h2 class="titulo-lista">Lista Asiganciones Roles-Permisos</h2>
                    <div class="buscar-dato">
                        <form method="GET" action="rol_permiso_vista.php" >
                            <div class="buscar-input">
                                <input type="text" name="busqueda" placeholder="Busqueda permiso..." title="Mostrar todos los registros campo vacio">
                            </div>
                            <div class="buscar-btn">
                                <button type="submit" class="btn btn-primary btn-block" >Buscar</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <?php
                    $sql = "SELECT rp.id_rp, r.nom_rol,p.nom_permiso, rp.created_at, rp.editado FROM db_tickets.tbl_permiso p
                        INNER JOIN db_tickets.tbl_roles_permisos rp ON p.id_permiso = rp.id_permiso
                        INNER JOIN db_tickets.tbl_rol r ON rp.id_rol = r.id_rol
                        WHERE IF('$varBuscar' = '', p.nom_permiso = 0,p.nom_permiso LIKE '%$regBuscar%')
                        AND rp.is_active = 1
                        ORDER BY rp.id_rp ASC;";
                        // var_dump($sql);
                    $result = $conn->query($sql);
                    ?>
                    <!--se despliega el resultado -->
                    <body>
                        <div style="overflow-x: auto;">
                            <table>  
                                <thead>
                                    <tr>
                                        <th scope='col'>Roles</th> 
                                        <th scope='col'>Permisos</th>
                                        <th scope='col'>Creado</th>
                                        <!-- <th scope='col'>Editado</th> -->
                                        <th scope='col'><center>Accion</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $fila['nom_rol']; ?></td>
                                        <td><?php echo $fila['nom_permiso']; ?></td>
                                        <td><?php echo $fila['created_at']; ?></td>
                                        <!-- <td><?php echo $fila['editado']; ?></td> -->
                                        <td>
                                            <center>
                                                <?php if (tiene_permiso('Modificar')) { ?>
                                                <a href="rol_permiso_vista.php?idrp=<?php echo $fila['id_rp']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                                <?php } else { ?>
                                                <a onclick="permiso();"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                                <?php } ?>
                                                <?php if (tiene_permiso('Eliminar')) { ?>
                                                <a href="rol_permiso_eliminar.php?idrp=<?php echo $fila['id_rp']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
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