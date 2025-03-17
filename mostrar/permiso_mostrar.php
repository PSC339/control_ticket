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
    </head>
    <body>
        <?php
            // conectamos la bd
            require "../config/conexion.php";
            //print_r($_GET);
            $var_recibido = isset($_GET['idPermiso']) ? $_GET['idPermiso'] : '0';

            if ($var_recibido != 0) {
                # code...
                $idPermiso = $_GET['idPermiso'];
                $sql = "SELECT * FROM db_tickets.tbl_permiso WHERE id_permiso = '$idPermiso'";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);
            }
            
            
            //var_dump($fila_id);
        ?>
        <div class="header">
            <div class="card_menu">
                <h2>Tickets</h2>
                <!-- <p>Tickets</p> -->
            </div>
        </div>

        <!-- <div class="topnav">
            <a href="#">Link</a>
            <a href="#">Link</a>
            <a href="#">Link</a>
        </div> -->

        <div class="row">
            <div class="column menu">
                <div class="card_menu">
                    <h2>Panel</h2>
                    <hr>
                    <nav class="csMenu">
                        <input id="hMenuBtn" type="checkbox" />
                        <label for="hMenuBtn"></label>
                        <ul id="hMenu" class="mVerti">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="usuario_mostrar.php">Usuarios</a></li>
                            <li><a href="rol_mostrar.php">Roles</a></li>
                            <li><a href="permiso_mostrar.php" class="active">Permisos</a></li>	
                            
                            <li><a href="#">Otros</a></li>
                            <li><a href="#">otros</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
    
            <div class="column formulario">
                <!-- <div class="row"> -->
                    <div class="card">
                        <?php if ($var_recibido == 0) { ?>
                            <h2>Nuevo Permiso</h2>
                        <hr>
                        <form action="permiso_agregar.php" method="POST">
                            <label for="input_permiso"><b>Permiso</b></label>
                            <input type="text" placeholder="Ingresa permiso" name="input_permiso" id="input_permiso" required>
                            <label for="input_nombre"><b>Nombre</b></label>
                            <input type="text" placeholder="Ingresa nombre permiso" name="input_nombre" id="input_nombre" required>
                            <div class="clearfix">
                                <div>
                                    <div class="btn_cancel">
                                        <button type="reset" class="btn btn-danger btn-block">Cancelar</button>
                                    </div>
                                    <div class="btn_agregar">
                                        <button type="submit" class="btn btn-success btn-block">Agregar</button>
                                    </div>.
                                </div>
                            </div>
                        </form>
                        <?php } else { ?>
                        <h2>Modificar Permiso</h2>
                        <hr>
                        <form action="permiso_editar.php" method="POST">
                            <label for="input_permiso"><b>Permiso</b></label>
                            <input type="text" placeholder="Ingresa permiso" name="input_permiso" id="input_permiso" value="<?php echo $fila_id['permiso']; ?>" required>
                            <input type="hidden"  name="id_permiso" value="<?php echo $fila_id['id_permiso']; ?>" />
                            <label for="input_nombre"><b>Nombre</b></label>
                            <input type="text" placeholder="Ingresa nombre permiso" name="input_nombre" id="input_nombre" value="<?php echo $fila_id['nom_permiso']; ?>" required>
                            <div class="clearfix">
                                <div>
                                    <div class="btn_cancel">
                                        <button type="reset" class="btn btn-danger btn-block">Cancel</button>
                                    </div>
                                    <div class="btn_agregar">
                                        <button type="submit" class="btn btn-success btn-block">Editar</button>
                                    </div>.
                                </div>
                            </div>
                        </form>
                        <?php } ?>
                        
                    </div>
                <!-- </div> -->
            </div>
    
            <div class="column vista">
            <div class="card">
                            <h2>Lista Permisos</h2>
                            <hr>
                            <?php
                            $sql = "SELECT * FROM db_tickets.tbl_permiso WHERE is_active=1;";
                            $result = $conn->query($sql);
                            //var_dump($result);
                            ?>
                            <!--se despliega el resultado -->
                            <body>
                                <div style="overflow-x: auto;">
                                    <table>  
                                        <thead>
                                        <tr>
                                        <th scope='col'>Permiso</th> 
                                        <th scope='col'>Nombre</th> 
                                        <th scope='col'><center>Accion</center></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($fila = $result->fetch_assoc()) { ?>
                                                <tr>
                                                <td><?php echo $fila['permiso']; ?></td>
                                                <td><?php echo $fila['nom_permiso']; ?></td>
                                                <td>
                                                    <center>
                                                        <a href="permiso_mostrar.php?idPermiso=<?php echo $fila['id_permiso']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                                        <a href="permiso_eliminar.php?idPermiso=<?php echo $fila['id_permiso']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
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