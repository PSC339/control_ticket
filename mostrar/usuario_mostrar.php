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
            $var_recibido = isset($_GET['idusuario']) ? $_GET['idusuario'] : '0';

            if ($var_recibido != 0) {
                # code...
                $idusuario = $_GET['idusuario'];
                $sql = "SELECT * FROM db_tickets.tbl_usuario WHERE id_usuario = '$idusuario'";
                $resultado = $conn->query($sql);
                $fila_id = $resultado->fetch_array(MYSQLI_ASSOC);
            }
        ?>

        <div class="header">
            <div class="card_menu">
            <h2>Tickets</h2>
            </div>
        </div>

        <!-- <div class="topnav">
            <a href="#">Link</a>
            <a href="#">Link</a>
            <a href="#">Link</a>
            <p>Bienvenidos</p>
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
                        <li><a href="usuario_mostrar.php" class="active">Usuarios</a></li>
                        <li><a href="rol_mostrar.php">Roles</a></li>
                        <li><a href="permiso_mostrar.php"">Permisos</a></li>	
                        
                        <li><a href="#">Otros</a></li>
                        <li><a href="#">otros</a></li>
                    </ul>
                    </nav>
                </div>
            </div>
    
            <div class="column formulario">
                <div class="card">
                    <?php if ($var_recibido == 0) { ?>
                        <h2>Nuevo Usuario</h2>
                    <hr>
                    <form action="usuario_agregar.php" method="POST">
                        <label for="input_rol"><b>Rol</b></label>
                        <input type="text" placeholder="Ingresa rol" name="input_rol" id="input_rol" required>
                        <label for="input_nombre"><b>Nombre</b></label>
                        <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" required>
                        <label for="input_apellido"><b>Apellido</b></label>
                        <input type="text" placeholder="Ingresa apellido" name="input_apellido" id="input_apellido" required>
                        <label for="input_usuario"><b>Usuario</b></label>
                        <input type="text" placeholder="Ingresa usuario" name="input_usuario" id="input_usuario" required>
                        <label for="input_email"><b>Correo</b></label>
                        <input type="text" placeholder="Ingresa email" name="input_email" id="input_email" required>
                        <label for="input_cntrasena"><b>Contrasena</b></label>
                        <input type="text" placeholder="Ingresa contrasena" name="input_cntrasena" id="input_cntrasena" required>
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
                    <h2>Modificar Usuario</h2>
                    <hr>
                    <form action="usuario_editar.php" method="POST">
                        <label for="input_rol"><b>Rol</b></label>
                        <input type="text" placeholder="Ingresa rol" name="input_rol" id="input_rol" value="<?php echo $fila_id['id_rol']; ?>" required>
                        <input type="hidden"  name="id_usuario" value="<?php echo $fila_id['id_usuario']; ?>" />
                        <label for="input_nombre"><b>Nombre</b></label>
                        <input type="text" placeholder="Ingresa nombre" name="input_nombre" id="input_nombre" value="<?php echo $fila_id['nombre']; ?>" required>
                        <label for="input_apellido"><b>Apellido</b></label>
                        <input type="text" placeholder="Ingresa apellido" name="input_apellido" id="input_apellido" value="<?php echo $fila_id['apellido']; ?>" required>
                        <label for="input_usuario"><b>Usuario</b></label>
                        <input type="text" placeholder="Ingresa usuario" name="input_usuario" id="input_usuario" value="<?php echo $fila_id['usuario']; ?>" required>
                        <label for="input_email"><b>Correo</b></label>
                        <input type="text" placeholder="Ingresa email" name="input_email" id="input_email" value="<?php echo $fila_id['email']; ?>" required>
                        <label for="input_cntrasena"><b>Contrasena</b></label>
                        <input type="text" placeholder="Ingresa contrasena" name="input_cntrasena" id="input_cntrasena" value="<?php echo $fila_id['contrasena']; ?>" required>
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
            </div>
    
            <div class="column vista">
                <div class="card">
                    <h2>Lista Usuarios</h2>
                    <hr>
                    <?php
                    $sql = "SELECT * FROM tbl_usuario";
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
                                <th scope='col'>Apellido</th>
                                <th scope='col'>Usuario</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Contrasena</th> 
                                <th scope='col'>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php while ($fila = $result->fetch_assoc()) { ?>
                                        <tr>
                                        <td><?php echo $fila['id_rol']; ?></td>
                                        <td><?php echo $fila['nombre']; ?></td>
                                        <td><?php echo $fila['apellido']; ?></td>
                                        <td><?php echo $fila['usuario']; ?></td>
                                        <td><?php echo $fila['email']; ?></td>
                                        <td><?php echo $fila['contrasena']; ?></td>
                                        <!-- <td><button class='btn_tb success btn-block'><a href="mostrar_user.php?idusuario=<?php echo $fila['id_usuario']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a></button></td> -->
                                        <td><a href="usuario_mostrar.php?idusuario=<?php echo $fila['id_usuario']; ?>"><img src="../img/pencil_24.png" alt="modificar" title="Modificar"></a>
                                            <a href="usuario_eliminar.php?idusuario=<?php echo $fila['id_usuario']; ?>"><img src="../img/trash_24.png" alt="eliminar" title="Eliminar"></a>
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