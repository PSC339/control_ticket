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
            
            $var_recibido = isset($_GET['idTicket']) ? $_GET['idTicket'] : '0';
            
            if ($var_recibido != 0) {
                # code...
                $id_ticket = $_GET['idTicket'];
                $sql = "SELECT * FROM db_tickets.tbl_tickets WHERE id = '$id_ticket'";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);

                $sqlPrioridad = "SELECT id_prioridad FROM db_tickets.tbl_tickets WHERE id = '$id_ticket';";
                $resultPrioridad = $conn->query($sqlPrioridad);
                $prioridadSeleccionada = null;
                if ($resultPrioridad->num_rows > 0) {
                    $rowPrioridad = $resultPrioridad->fetch_assoc();
                    $prioridadSeleccionada = $rowPrioridad['id_prioridad']; // Guardamos el id de la categoría
                }
            }

            // Valido si el input viene null si es null le asigno un 0.
            $varBuscar = !empty($_GET['buscaTicket']) ? $_GET['buscaTicket'] : '0';
            if ($varBuscar != 0) {
                $regBuscar = $_GET['buscaTicket'];
            }
        
            $sqlPrioridad = "SELECT id_prioridad,nombre FROM db_tickets.tbl_cat_prioridad;";
            $resultPrioridad = $conn->query($sqlPrioridad);

            
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
                            <li><a href="rol_mostrar.php">Roles</a></li>
                            <li><a href="permiso_mostrar.php">Permisos</a></li>
                            <li><a href="ticketsValidacion_vista.php">Técnicos</a></li>
                            <li><a href="ticketsCerrados_vista.php">Cerrados</a></li>
                            <li><a href="tickets_vista.php" class="active">Tickets</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['rol']=='Tecnico') { ?>
                            <li><a href="ticketsValidacion_vista.php">Técnicos</a></li>
                            <li><a href="ticketsCerrados_vista.php">Cerrados</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['rol']=='Empleado') { ?>
                            <li><a href="tickets_vista.php" class="active">Tickets</a></li>
                            <!-- <li><a href="#">Técnico</a></li> -->
                        <?php } ?>
                    </ul>
                    </nav>
                </div>
            </div>
    
            <div class="column formulario">
                <div class="card">
                    <?php if ($var_recibido == 0) { ?>
                        <h2>Nuevo Ticket</h2>
                    <hr>
                    <form action="ticket_agregar.php" method="POST">
                        <label for="txt_asunto"><b>Asunto</b></label>
                        <textarea id="txt_asunto" name="txt_asunto" rows="2" cols="50" placeholder="Igresa el asunto" required></textarea>
                        <label for="txt_desc"><b>Descripción</b></label>
                        <textarea id="txt_desc" name="txt_desc" rows="4" cols="50" placeholder="Igresa la descripción" required></textarea>
                        <label for="input_area"><b>Area</b></label>
                        <input type="text" placeholder="Ingresa el area" name="input_area" id="input_area" required>
                        <!-- <label for="input_ubicacion"><b>Ubicación</b></label>
                        <input type="text" placeholder="Ingresa la ubicación" name="input_ubicacion" id="input_ubicacion" required> -->
                        <label for="sb_prioridad"><b>Prioridad</b></label>
                        <select id="sb_prioridad" name="sb_prioridad" >
                            <option value="0" required>Elige una opción...</option>
                            <?php
                                if ($resultPrioridad->num_rows > 0) {
                                    while ($catPrioridad = $resultPrioridad->fetch_assoc()) {
                                        echo '<option value="' . $catPrioridad['id_prioridad'] . '" ' . $selected . '>' . $catPrioridad['nombre'] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                        <input type="hidden"  name="input_user" value="<?php echo $_SESSION['name_user']; ?>" />
                        <!-- <label for="input_estatus"><b>Estatus</b></label>
                        <input type="text" placeholder="Ingresa el estatus" name="input_estatus" id="input_estatus" required> -->
                        <div class="clearfix">
                            <div class="row">
                                <div class="btn_cancel">
                                    <button type="reset" class="btn btn-danger btn-block" onclick="limpiar();">Cancelar</button>
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
                    <h2>Modificar Ticket</h2>
                    <hr>
                    <form action="ticket_editar.php" method="POST">
                        <label for="txt_asunto"><b>Asunto</b></label>
                        <textarea id="txt_asunto" name="txt_asunto" rows="4" cols="50" required><?php echo htmlspecialchars($fila_id['asunto']); ?></textarea>
                        <label for="txt_desc"><b>Descripción</b></label>
                        <textarea id="txt_desc" name="txt_desc" rows="4" cols="50" required><?php echo htmlspecialchars($fila_id['descripcion']); ?></textarea>
                        <input type="hidden"  name="id_ticket" value="<?php echo $fila_id['id']; ?>" />
                        <label for="input_area"><b>Modulo</b></label>
                        <input type="text" placeholder="Ingresa el modulo" name="input_area" id="input_area" value="<?php echo $fila_id['area']; ?>" required>
                        <!-- <label for="input_apellido"><b>Ubicación</b></label>
                        <input type="text" placeholder="Ingresa la ubicacion" name="input_ubicacion" id="input_ubicacion" value="<?php echo $fila_id['ubicacion']; ?>" required> -->
                        <!-- <label for="input_prioridad"><b>Prioridad</b></label>
                        <input type="text" placeholder="Ingresa la prioridad" name="input_prioridad" id="input_prioridad" value="<?php echo $fila_id['prioridad']; ?>" required> -->
                        <select id="sb_prioridad" name="sb_prioridad" >
                            <option value="0" required>Elige una opción...</option>
                            <?php
                                if ($resultPrioridad->num_rows > 0) {
                                    while ($catEditarPrioridad = $resultPrioridad->fetch_assoc()) {
                                        // Comprobar si esta categoría es la seleccionada
                                        $selected = ($catEditarPrioridad['id_prioridad'] == $prioridadSeleccionada) ? 'selected' : '';
                                        echo '<option value="' . $catEditarPrioridad['id_prioridad'] . '" ' . $selected . '>' . $catEditarPrioridad['nombre'] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                        <!-- <label for="input_email"><b>Estatus</b></label>
                        <input type="text" placeholder="Ingresa el estatus" name="input_estatus" id="input_estatus" value="<?php echo $fila_id['estatus']; ?>" required> -->
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
                        <h2>Lista Tickets</h2>
                    </div>
                    <div class="buscar-dato">
                        <form method="GET" action="tickets_vista.php" >
                            <div class="buscar-input">
                                <input type="text" name="buscaTicket" placeholder="Busqueda ticket..." title="Mostrar todos los registros campo vacio">
                            </div>
                            <div class="buscar-btn">
                                <button type="submit" class="btn btn-primary btn-block" >Buscar</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <?php
                    $sql = "SELECT t.id, t.numero, t.created_at, t.asunto, t.area, cp.nombre FROM db_tickets.tbl_tickets t
                        INNER JOIN db_tickets.tbl_cat_prioridad cp ON t.id_prioridad = cp.id_prioridad
                        WHERE IF('$varBuscar' = '', t.numero = 0, t.numero LIKE '%$regBuscar%')
                        AND t.is_active = 1;";
                    $result = $conn->query($sql);
                    // var_dump($sql);
                    ?>
                    <!--se despliega el resultado -->
                    <body>
                        <div class="table-wrapper" style="overflow-x: auto;">
                            <table>  
                                <thead>
                                <tr>
                                <th scope='col'>Numero</th> 
                                <th scope='col'>Creado</th> 
                                <th scope='col'>Asunto</th> 
                                <th scope='col'>Area</th>
                                <!-- <th scope='col'>Ubicacion</th> -->
                                <th scope='col'>Prioridad</th>
                                <!-- <th scope='col'>Estatus</th> -->
                                <th scope='col'>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = $result->fetch_assoc()) { ?>
                                        <tr>
                                        <td><?php echo $fila['numero']; ?></td>
                                        <td><?php echo $fila['created_at']; ?></td>
                                        <td><?php echo $fila['asunto']; ?></td>
                                        <td><?php echo $fila['area']; ?></td>
                                        <!-- <td><?php echo $fila['ubicacion']; ?></td> -->
                                        <td><?php echo $fila['nombre']; ?></td>
                                        <!-- <td><?php echo $fila['estatus']; ?></td> -->
                                        <td>
                                            <?php if (tiene_permiso('Modificar')) { ?>
                                                <a href="tickets_vista.php?idTicket=<?php echo $fila['id']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                            <?php } else { ?>
                                                <a onclick="permiso();"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                            <?php } ?>
                                            <?php if (tiene_permiso('Eliminar')) { ?>
                                                <a href="ticket_eliminar.php?idTicket=<?php echo $fila['id']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
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