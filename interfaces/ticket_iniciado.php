<?php
    require "../config/conexion.php";
        // $varRecibido = $_GET;
        $var_numero_tk = $_GET['idTicket'];
        // var_dump($var_numero_tk);
        $sql_agregar = "INSERT INTO db_tickets.tbl_subtickets (numero_tk) VALUES ('$var_numero_tk');";
        // print_r($sql_agregar);
        mysqli_query($conn,$sql_agregar);
