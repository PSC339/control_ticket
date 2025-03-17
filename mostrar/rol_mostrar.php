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
            require "../config/conexion.php";
            //print_r($_GET);
            $var_recibido = isset($_GET['idrol']) ? $_GET['idrol'] : '0';

            if ($var_recibido != 0) {
                # code...
                $idrol = $_GET['idrol'];
                $sql = "SELECT * FROM db_tickets.tbl_rol WHERE id_rol = '$idrol'";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);
            }
        ?>

        <div class="header">
            <div class="card_menu">
                <h2>Tickets</h2>
            </div>
        </div>

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
                            <li><a href="rol_mostrar.php" class="active">Roles</a></li>
                            <li><a href="permiso_mostrar.php">Permisos</a></li>	
                            
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
                                <h2>Nuevo Rol</h2>
                            <hr>
                            <form action="rol_agregar.php" method="POST">
                                <label for="input_rol"><b>Nivel</b></label>
                                <input type="text" placeholder="Ingresa rol" name="input_rol" id="input_rol" required>
                                <label for="input_nombre"><b>Nombre</b></label>
                                <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" required>
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
                            <h2>Modificar   Rol</h2>
                            <hr>
                            <form action="rol_editar.php" method="POST">
                                <label for="input_rol"><b>Nivel</b></label>
                                <input type="text" placeholder="Ingresa rol" name="input_rol" id="input_rol" value="<?php echo $fila_id['rol']; ?>" required>
                                <input type="hidden"  name="id_rol" value="<?php echo $fila_id['id_rol']; ?>" />
                                <label for="input_nombre"><b>Nombre</b></label>
                                <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" value="<?php echo $fila_id['nom_rol']; ?>" required>
                                <div class="clearfix">
                                    <div>
                                        <div class="btn_cancel">
                                            <button type="reset" class="btn btn-danger btn-block">Cancelar</button>
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
                    <h2>Lista Roles</h2>
                    <hr>
                    <?php
                    $sql = "SELECT * FROM db_tickets.tbl_rol WHERE is_active=1;";
                    $result = $conn->query($sql);
                    //var_dump($result);
                    ?>
                    <!--se despliega el resultado -->
                    <body>
                        <div style="overflow-x: auto;">
                            <table>  
                                <thead>
                                <tr>
                                <th scope='col'>Rol</th> 
                                <th scope='col'>Nombre</th> 
                                <th scope='col'><center>Accion</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = $result->fetch_assoc()) { ?>
                                        <tr>
                                        <td><?php echo $fila['rol']; ?></td>
                                        <td><?php echo $fila['nom_rol']; ?></td>
                                        <td>
                                            <center>
                                                <a href="rol_mostrar.php?idrol=<?php echo $fila['id_rol']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                                <a href="rol_eliminar.php?idrol=<?php echo $fila['id_rol']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
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