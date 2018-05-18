<!DOCTYPE html>
<html lang="es">
<?php
    include("header.php");
    $bd_admin->conectar();
    switch ($_REQUEST['accion']) {
        case 'crear_usuario':
            $bd_admin->crear_usuario($_REQUEST);
            break;
        case 'Inactivar':
            $bd_admin->cambiar_estado($_REQUEST['nombre_usuario'], 0);
            break;
        case 'Activar':
            $bd_admin->cambiar_estado($_REQUEST['nombre_usuario'], 1);
            break;
        case 'Eliminar':
            $bd_admin->eliminar_usuario($_REQUEST['nombre_usuario']);
            break;
    }

    // Consultar los usuarios registrados
    $usuarios = $bd_admin->consultar_usuarios(false);
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Administrar > Gestionar usuarios</h1>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-form-label">
                <h4>Crear usuario</h4>
            </div><br>
            <div class="col-sm-12">
                <form method="POST" action="#">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="nombre_usuario">Nombre</label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required="required" autocomplete="off">
                        </div>
                        <div class="form-group col-md-3 offset-md-1">
                            <label for="clave_usuario">Contraseña</label>
                            <input type="password" class="form-control" id="clave_usuario" name="clave_usuario" required="required" autocomplete="off">
                        </div>
                        <div class="form-group col-md-3 offset-md-1">
                            <label for="estado_usuario">Estado</label>
                            <div class="input-group">
                                <select class="form-control" id="estado_usuario" name="estado_usuario" required="required">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php if( $bd_admin->conectar(False) && $bd_admin->verificar_tabla('usuarios') ): ?>
                    <div class="form-row">
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary">Crear</button>
                            <input type="hidden" name="accion" value="crear_usuario">
                        </div>
                        <div class="col-sm-6">
                            <small style="color:gray;">Los espacios en blanco en el nombre y la contraseña serán eliminados.</small>
                        </div>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-form-label">
                <h4>Listado de usuarios</h4>
            </div><br>
            <div class="col-sm-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th style="width:25%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usuarios as $key => $row): ?>
                        <tr>
                            <td><?php echo $row['nombre_usuario']; ?></td>
                            <td><?php echo $row['estado_usuario'] ? 'Activo' : 'Inactivo'; ?></td>
                            <td style="text-align: right;">
                                <?php if($row['nombre_usuario']!='admin'): ?>
                                <form action="#">
                                    <?php if($row['estado_usuario']): ?>
                                    <input type="submit" class="btn btn-sm btn-warning" name="accion" value="Inactivar">
                                    <?php else: ?>
                                    <input type="submit" class="btn btn-sm btn-success" name="accion" value="Activar">
                                    <?php endif; ?>
                                    <input type="submit" class="btn btn-sm btn-danger" name="accion" value="Eliminar">
                                    <input type="hidden" name="nombre_usuario" value="<?php echo $row[nombre_usuario] ?>">
                                </form>
                                <?php else: ?>
                                    <small style="color:gray;">El usuario admin no se puede eliminar</small>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container container-fluid py-md-4">
    <?php if ($bd_admin->mensaje!="") echo '<div class="alert alert-info" role="alert">'.$bd_admin->mensaje.'</div>'; ?>
    <p>
        <a class="btn btn-link" href="administrar.php">Volver</a>
    </p>
    </div>
</body>
</html>
