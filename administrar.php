<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");

    require_once('bd/BDAdmin.php');
    $bd_admin = new BDAdmin();
    switch ($_REQUEST['accion']) {
        case 'crear_bd':
            if ($bd_admin->crear_bd()) {
                $bd_admin->conectar();
            }
            break;
        case 'crear_tabla':
            if ($bd_admin->conectar()) {
                $bd_admin->crear_tabla();
            }
            break;
            
        case 'borrar_bd':
            if ($bd_admin->conectar()) {
                $bd_admin->borrar_bd();
            }
            break;

        case 'borrar_producto':
            if ($bd_admin->conectar()) {
                $codigo = $_REQUEST['codigo_producto'];
                $bd_admin->borrar_producto($codigo);
            }
            break;
    }
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Administrar</h1>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-form-label">
                <label>Crear la base de datos</label>
            </div>
            <div class="col-sm-3">
                <form method="POST" action="#">
                    <button type="submit" class="btn btn-primary">Crear BD</button>
                    <input type="hidden" class="form-control" name="accion" value="crear_bd">
                </form>
            </div>
        </div>
        <hr>
        <?php if( $bd_admin->conectar(False) && !$bd_admin->verificar_tabla() ): ?>
        <div class="row">
            <div class="col-sm-6 col-form-label">
                <label>Crear la tabla para la base de datos</label>
            </div>
            <div class="col-sm-3">
                <form method="POST" action="#">
                    <button type="submit" class="btn btn-primary">Crear tabla</button>
                    <input type="hidden" class="form-control" name="accion" value="crear_tabla">
                </form>
            </div>
        </div>
        <hr>
        <?php endif; ?>
        <?php if($bd_admin->conectar(False)): ?>
        <div class="row">
            <div class="col-sm-6 col-form-label">
                <label>Borrar la base de datos</label>
            </div>
            <div class="col-sm-3">
                <form method="POST" action="#">
                    <button type="submit" class="btn btn-danger">Borrar BD</button>
                    <input type="hidden" class="form-control" name="accion" value="borrar_bd">
                </form>
            </div>
        </div>
        <hr>
        <?php endif; ?>
        <?php if( $bd_admin->conectar(False) && $bd_admin->verificar_tabla() ): ?>
        <div class="row">
            <div class="col-sm-12 col-form-label">
                <h4>Borrar un producto</h4>
            </div><br>
            <div class="col-sm-12">
                <form method="POST" action="#">
                    <div class="form-group row">
                        <label for="codigo_producto" class="col-sm-2 col-form-label">Código</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="codigo_producto" name="codigo_producto" required="required" value="<?php echo $_REQUEST['codigo_producto'] ?>">
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-outline-danger">Borrar producto</button>
                            <input type="hidden" class="form-control" name="accion" value="borrar_producto">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <?php endif; ?>
    </div>
    <div class="container container-fluid py-md-4">
    <?php
        if ($bd_admin->mensaje!="") {
            echo '<div class="alert alert-info" role="alert">'.$bd_admin->mensaje.'</div>';
        }
    ?>
    </div>
</body>
</html>

