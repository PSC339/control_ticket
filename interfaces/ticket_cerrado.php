<?php
    require "../config/conexion.php";

        $var_fechaCerrado = $_GET['idTicket'];

        $sqlNumero = "SELECT finalizado,COUNT(finalizado) cerrado FROM db_tickets.tbl_subtickets where numero_tk = '$var_fechaCerrado';";
        $resNumero = $conn->query($sqlNumero);
        $fila = $resNumero->fetch_assoc();
        $fcerrado =  $fila["cerrado"];

        if ($fcerrado == 0) {
            $sql_cerrar = "UPDATE db_tickets.tbl_subtickets SET finalizado = NOW() WHERE numero_tk = '$var_fechaCerrado';";
            print_r($sql_cerrar);
            mysqli_query($conn,$sql_cerrar);
            header("location:ticketsCerrados_vista.php");
        }
         else {
            header("location:ticketsCerrados_vista.php");
            // echo "Ya esta cerrado...";
        }


