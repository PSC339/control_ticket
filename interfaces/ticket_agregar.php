
<?php
    
    require "../config/conexion.php";

    // Configurar la zona horaria a 'America/New_York'
    date_default_timezone_set('America/Mexico_City');
    $var_asunto = $_POST['txt_asunto'];
    $var_desc = $_POST['txt_desc'];
    $var_area = $_POST['input_area'];
    // $var_ubicacion = $_POST['input_ubicacion'];
    $var_prioridad = $_POST['sb_prioridad'];
    // $var_estatus = $_POST['input_estatus'];
    $sql_id = "SELECT IFNULL(MAX(id) + 1,001) as id_ticket FROM db_tickets.tbl_tickets;";
    $result =  mysqli_query($conn,$sql_id);
    $row = mysqli_fetch_assoc($result);
    $ultimo_id = $row['id_ticket'];
    $nuevo_ticket = 'tk_' . str_pad($ultimo_id, 3, '0', STR_PAD_LEFT);
    $varUser = $_POST['input_user'];
    // echo "El último ID insertado es: " . $ultimo_id;
    // $fechaHora = date("Ymd-His");
    // // Crear el identificador combinando el ID y la fecha/hora
    // $ticket_id = $ultimo_id . "-" . $fechaHora;
    // // echo "El identificador del ticket es: " . $ticket_id;

   
    $sql_agregar = "INSERT INTO db_tickets.tbl_tickets (numero,asunto,descripcion,area,id_prioridad,usuario) VALUES ('$nuevo_ticket','$var_asunto','$var_desc','$var_area','$var_prioridad','$varUser');";
    // print_r($sql_agregar);
    mysqli_query($conn,$sql_agregar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:tickets_vista.php");


