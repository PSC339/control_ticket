
<?php
    
    require "../config/conexion.php";

    $var_idTicket = $_POST['id_ticket'];
    $var_asunto = $_POST['txt_asunto'];
    $var_desc = $_POST['txt_desc'];
    $var_area = $_POST['input_area'];
    $var_prioridad = $_POST['sb_prioridad'];
    // $var_estatus = $_POST['input_estatus'];
   
    $sql_editar = "UPDATE db_tickets.tbl_tickets SET asunto = '$var_asunto', descripcion = '$var_desc', area = '$var_area', id_prioridad = '$var_prioridad', editado=now() WHERE id = '$var_idTicket';";
    // var_dump($sql_editar);
    mysqli_query($conn,$sql_editar);
    mysqli_close($conn);
    // Retorna pagina de cargado usuario...
    header("location:tickets_vista.php");


