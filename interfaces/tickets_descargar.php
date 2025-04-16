<?php
require "../config/conexion.php";

$varNumTicket = $_POST['input_num'];
// var_dump($varNumTicket);

// Incluir PHPExcel
require '../Excel/PHPExcel.php';
// Crear nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Tu Nombre")
                             ->setTitle("Exportación de Usuarios");

// Encabezados
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Numero')
            ->setCellValue('B1', 'Creado')
            ->setCellValue('C1', 'Asunto')
            ->setCellValue('D1', 'Descripcion')
            ->setCellValue('E1', 'Area')
            ->setCellValue('F1', 'Prioridad')
            ->setCellValue('G1', 'Usuario');

// Obtener datos desde la base de datos
$sql = "SELECT t.numero,
            t.created_at,
            t.asunto,
            t.descripcion,
            t.area,
            cp.nombre,
            t.usuario as nombre_us
        FROM db_tickets.tbl_tickets t
        INNER JOIN db_tickets.tbl_cat_prioridad cp ON t.id_prioridad = cp.id_prioridad
        LEFT JOIN db_tickets.tbl_subtickets sb ON t.numero = sb.numero_tk
        WHERE t.numero = '$varNumTicket'
        AND t.is_active = 1
        GROUP BY numero;";
$result = $conn->query($sql);

$fila = 2; // Inicia en la fila 2 porque la 1 tiene encabezados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A$fila", $row['numero'])
                    ->setCellValue("B$fila", $row['created_at'])
                    ->setCellValue("C$fila", $row['asunto'])
                    ->setCellValue("D$fila", $row['descripcion'])
                    ->setCellValue("E$fila", $row['area'])
                    ->setCellValue("F$fila", $row['nombre'])
                    ->setCellValue("G$fila", $row['nombre_us']);
        $fila++;
    }
}

// Renombrar hoja
$objPHPExcel->getActiveSheet()->setTitle('Tickets');

// Establecer hoja activa
$objPHPExcel->setActiveSheetIndex(0);

// Configurar encabezados para descarga
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Ticket.xls"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');

// Limpiar el búfer de salida
ob_clean();

// Guardar archivo y enviarlo al navegador
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>