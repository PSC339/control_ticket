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
            //print_r($_GET);
            $var_recibido = isset($_GET['idTicket']) ? $_GET['idTicket'] : '0';

            if ($var_recibido != 0) {
                # code...
                $idTicket = $_GET['idTicket'];
                $sql = "SELECT * FROM db_tickets.tbl_tickets WHERE id = '$idTicket'";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);
                // var_dump($fila_id);

                $sqlPrioridad = "SELECT id_prioridad FROM db_tickets.tbl_tickets WHERE id = '$idTicket';";
                $resultPrioridad = $conn->query($sqlPrioridad);
                $prioridadSeleccionada = null;
                if ($resultPrioridad->num_rows > 0) {
                    $rowPrioridad = $resultPrioridad->fetch_assoc();
                    $prioridadSeleccionada = $rowPrioridad['id_prioridad']; // Guardamos el id de la categoría
                    //  var_dump($prioridadSeleccionada);
                }

                // $var_iniciado = $_GET['idTicket'];
                // var_dump($var_iniciado);
                $sqlIniciado = "SELECT COUNT(iniciado) qtyTicket, iniciado FROM db_tickets.tbl_subtickets where numero_tk = '$idTicket';";
                // var_dump($sqlIniciado);
                $resIniciado = $conn->query($sqlIniciado);
                $fila = $resIniciado->fetch_assoc();
                // $fIniaciado = $fila["iniciado"];
                $ticketIniciado =  $fila["qtyTicket"];
                // echo $ticketIniciado;

                if ($ticketIniciado == 1) {
                    echo "<script>ticket();</script>";
                }
                elseif($ticketIniciado == 0){
                    require "ticket_iniciado.php";
                }
            }
        
            $sqlPrioridad = "SELECT id_prioridad,nombre FROM db_tickets.tbl_cat_prioridad;";
            $resultPrioridad = $conn->query($sqlPrioridad);

            // $var_recibido = isset($_GET['idTicket']) ? $_GET['idTicket'] : '0';
            // if ($var_recibido != 0) {
            //     $var_fechaCerrado = $_GET['idTicket'];
            //     // var_dump($var_fechaCerrado);
            //     $sqlNumero = "SELECT COUNT(finalizado) cerrado, finalizado FROM db_tickets.tbl_subtickets where numero_tk = '$var_fechaCerrado';";
            //     $resNumero = $conn->query($sqlNumero);
            //     $fila = $resNumero->fetch_assoc();
            //     $fcerrado = $fila["cerrado"];
            //     $finTicket =  $fila["finalizado"];
            //     // echo $finTicket;

            //     if ($fcerrado == 1) {
            //         echo "<script>ticket();</script>";
            //         // header("location:validacion_tickets_vista.php");
                    
            //     }
            //     elseif($finTicket == 0){
            //         require "ticket_cerrado.php";
            //     }
            // }

            // Valido si el input viene null si es null le asigno un 0.
            $varBuscar = !empty($_GET['busqueda']) ? $_GET['busqueda'] : '0';
            // var_dump("Hola soy el input busqueda: ".$varBuscar);
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
                            <li><a href="ticketsValidacion_vistaphp" class="active">Técnicos</a></li>
                            <li><a href="ticketsCerrados_vista.php">Cerrados</a></li>
                            <li><a href="tickets_vista.php" >Tickets</a></li>
                        <?php } ?>
                        <?php if ($_SESSION['rol']=='Tecnico') { ?>
                            <li><a href="ticketsValidacion_vista.php" class="active">Técnicos</a></li>
                            <li><a href="ticketsCerrados_vista.php">Cerrados</a></li>
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
                    <h2 class="titulo-lista">Lista Tickets</h2>
                    <div class="buscar-dato">
                        <form method="GET" action="ticketsValidacion_vista.php" >
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
                            AND sb.finalizado IS NULL
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
                                            <th scope='col'><center>Accion</center></th>
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
                                            <td>
                                                <center>
                                                    <?php if (tiene_permiso('Iniciar')) { ?>
                                                        <a href="ticketsValidacion_vista.php?idTicket=<?php echo $fila['numero']; ?>"><img src="../img/iniciar_24.png" alt="modificar" title="Iniciar"></a>
                                                    <?php } else { ?>
                                                        <a onclick="permiso();"><img src="../img/iniciar_24.png" alt="modificar" title="Modificar"></a>
                                                    <?php } ?>
                                                    <?php if (tiene_permiso('Cerrar')) { ?>
                                                        <a href="ticket_cerrado.php?idTicket=<?php echo $fila['numero_tk']; ?>"><img src="../img/cticket_24.png" alt="modificar" title="Cerrar"></a>
                                                    <?php } else { ?>
                                                        <a onclick="permiso();"><img src="../img/cticket_24.png" alt="modificar" title="Modificar"></a>
                                                    <?php } ?>
                                                    <!-- <?php if (tiene_permiso('Eliminar')) { ?>
                                                        <a href="ticket_eliminar.php?idTicket=<?php echo $fila['id']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
                                                    <?php } else { ?>
                                                        <a onclick="permiso();"><img src="../img/trash_24.png" alt="modificar" title="Modificar"></a>
                                                    <?php } ?> -->
                                                </center>
                                            </td>
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