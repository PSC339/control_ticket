<?php
    // confirmar sesion
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../index.html');
        exit;
    }
    require "../login/verifica_permiso.php";
    // require "ticket_validaExiste.php";
    //  echo $myjson;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tickets</title>
        <meta charset="utf-8">
        <?php  ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/menu_vertical.css" />
        <link rel="stylesheet" href="../css/diseño_detalle.css">
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
            // Valido si el input viene null si es null le asigno un 0.
            $varBuscar = !empty($_GET['busqueda']) ? $_GET['busqueda'] : '0';
            // var_dump( "En la validacion le asigno: ".$varBuscar);
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
            <div class="col menu-detail">
                <div class="card_menu">
                    <!-- <center> -->
                    <h4>Menu: <b><?= $_SESSION['rol'] ?></b></h4>
                    <!-- </center> -->
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
                            <li><a href="ticketsCerrados_vista.php" class="active">Cerrados</a></li>
                            <li><a href="tickets_vista.php" >Tickets</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['rol']=='Tecnico') { ?>
                            <li><a href="ticketsValidacion_vista.php">Técnicos</a></li>
                            <li><a href="ticketsCerrados_vista.php" class="active">Cerrados</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['rol']=='Empleado') { ?>
                            <li><a href="tickets_vista.php" >Tickets</a></li>
                            <!-- <li><a href="#">Técnico</a></li> -->
                        <?php } ?>
                    </ul>
                    </nav>
                </div>
            </div>
            
            <div class="col vista-detail">
                <div class="card">
                    <h2 class="titulo-lista">Tickets Cerrados</h2>
                    <div class="buscar-dato">
                        <form method="GET" action="ticketsCerrados_vista.php" >
                            <div class="buscar-input">
                                <input type="text" name="busqueda" placeholder="Busqueda ticket..." title="Mostrar todos los registros campo vacio">
                            </div>
                            <div class="buscar-btn">
                                <button type="submit" class="btn btn-primary btn-block" >Buscar</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <?php
                    $sql = "SELECT t.id, t.numero, t.created_at, t.asunto, t.area, cp.nombre, sb.numero_tk,
                            CASE WHEN sb.iniciado IS NULL THEN 'No iniciado'
                            -- WHEN sb.iniciado > CURDATE() THEN 'No iniciado'
                            WHEN sb.iniciado IS NOT NULL AND sb.finalizado IS NULL THEN 'En verificacion'
                           -- WHEN sb.iniciado <= CURDATE() AND sb.finalizado IS NULL THEN 'En verificacion'
                            WHEN sb.finalizado IS NOT NULL THEN 'Cerrado'
                            ELSE 'Desconocido'
                            END AS estatus,sb.iniciado, sb.finalizado
                            FROM db_tickets.tbl_tickets t
                            INNER JOIN db_tickets.tbl_cat_prioridad cp ON t.id_prioridad = cp.id_prioridad
                            LEFT JOIN db_tickets.tbl_subtickets sb ON t.numero = sb.numero_tk
                            WHERE IF('$varBuscar' = '', t.numero = 0, t.numero LIKE '%$regBuscar%')
                            AND t.is_active = 1
                            AND sb.finalizado IS NOT NULL
                            GROUP BY numero;";
                    $result = $conn->query($sql);
                    // var_dump($sql);
                    ?>
                    <!--se despliega el resultado -->
                    <body>
                        <div class="table-wrapper" style="overflow-x: auto;">
                            <!-- <div class="container"> -->
                                <table>  
                                    <thead>
                                        <tr>
                                            <th scope='col'>Numero</th> 
                                            <th scope='col'>Creado</th> 
                                            <th scope='col'>Asunto</th>
                                            <th scope='col'>Area</th>
                                            <!-- <th scope='col'>Ubicacion</th> -->
                                            <th scope='col'>Prioridad</th>
                                            <th scope='col'><center>Estatus</center></th>
                                            <!-- <th scope='col'><center>Accion</center></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($fila = $result->fetch_assoc()) { ?>
                                            <?php
                                                // Determinar el estado basado en las fechas
                                                $estado = '';
                                                $fecha_inicio = $fila['iniciado'];
                                                $fecha_fin = $fila['finalizado'];
                                            ?>
                                            <tr >
                                                <td>
                                            <!-- <td><?php echo $fila['numero']; ?> -->
                                                <a href="ticket_detalle.php?idTk=<?php echo $fila['numero']; ?>" >
                                                    <?php echo $fila['numero']; ?>
                                                </a>
                                            </td>
                                            <td><?php echo $fila['created_at']; ?></td>
                                            <td><?php echo $fila['asunto']; ?></td>
                                            <td><?php echo $fila['area']; ?></td>
                                            <!-- <td><?php echo $fila['ubicacion']; ?></td> -->
                                            <td><?php echo $fila['nombre']; ?></td>
                                            <?php if ($fecha_inicio == NULL || $fecha_inicio > date('Y-m-d')) { ?>
                                                <td><center><span class="no-iniciado"><?php echo $fila['estatus']; ?></span></center></td>
                                            <?php }
                                            elseif ($fecha_fin == NULL) { ?>
                                                <td ><center><span class="en-verificacion"><?php echo $fila['estatus']; ?></span></center></td>    
                                            <?php } else { ?>
                                                <td><center><span class="finalizado"><?php echo $fila['estatus']; ?></span></center></td>
                                            <?php }?>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <!-- </div> -->
                        </div>
                    </body>
                </div>
            </div>
        </div>
    
    </body>
</html>