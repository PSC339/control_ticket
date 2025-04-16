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
                $idTicket = $_GET['idTk'];
                $sqlDetalle = "SELECT t.id, t.numero, t.created_at, t.asunto, t.descripcion, t.area, cp.nombre, sb.numero_tk,t.usuario,
                    CASE WHEN sb.iniciado IS NULL THEN 'No iniciado'
                    -- WHEN sb.iniciado > CURDATE() THEN 'No iniciado'
                    WHEN sb.iniciado IS NOT NULL AND sb.finalizado IS NULL THEN 'En verificacion'
                    -- WHEN sb.iniciado <= CURDATE() AND sb.finalizado IS NULL THEN 'En verificacion'
                    WHEN sb.finalizado IS NOT NULL THEN 'Finalizado'
                    ELSE 'Desconocido'
                    END AS estatus,sb.iniciado, sb.finalizado, timediff(sb.finalizado, sb.iniciado) transcurrido
                    FROM db_tickets.tbl_tickets t
                    INNER JOIN db_tickets.tbl_cat_prioridad cp ON t.id_prioridad = cp.id_prioridad
                    LEFT JOIN db_tickets.tbl_subtickets sb ON t.numero = sb.numero_tk
                    WHERE t.numero = '$idTicket'
                    AND t.is_active = 1
                    --  AND sb.finalizado IS NULL
                    GROUP BY numero;";
                $resultado = $conn->query($sqlDetalle);
                $rowTicket = $resultado->fetch_array(MYSQLI_ASSOC);
            
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
                <div class="card">
                    <label for="lbl_numero" class="lbl_details">Numero Ticket:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['numero'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Estatus:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['estatus'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Prioridad:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['nombre'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Fecha creación:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['created_at'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Tiempo Transcurrido:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['transcurrido'] ?></span>
                </div>
            </div>
    
            <div class="column formulario">
                <div class="card">
                    <label for="lbl_numero" class="lbl_details">Iniciado:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['iniciado'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Finalizado:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['finalizado'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Area:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['area'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Creado por:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['usuario'] ?></span>
                    <br>
                </div>            
            </div>
    
            <div class="column vista">
                <div class="card">
                    <label for="lbl_numero" class="lbl_details">Asunto:</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['asunto'] ?></span>
                    <br>
                    <label for="lbl_numero" class="lbl_details">Descripción</label>
                    <span id="lbl_numero" class="sp_detail"><?php echo $rowTicket['descripcion'] ?></span>
                    <br>
                </div>
            </div>
            
        </div>
        <div class="btns-ticket">
            <div class="export">
                <form action="tickets_descargar.php" method="post">
                    <button type="submit" id="export_data" name='export_data'
                    value="Export to excel" class="btn btn-success">Exportar</button>
                    <input type="hidden" name="input_num" value="<?php echo $rowTicket['numero'] ?>">
                </form>
            </div>
            <div class="retorno">
                <?php
                    $status = $rowTicket['estatus'];
                    if ($status == "Finalizado") { ?>
                        <a href="ticketsCerrados_vista.php"><button class="btn btn-primary">Regresar</button></a>
                <?php }
                    if ($status == "No iniciado") { ?>
                        <a href="ticketsValidacion_vista.php"><button class="btn btn-primary">Regresar</button></a>
                <?php }
                    if ($status == "En verificacion") { ?>
                        <a href="ticketsValidacion_vista.php"><button class="btn btn-primary">Regresar</button></a>
                <?php } ?>
            </div>
        </div>
    </body>
</html>