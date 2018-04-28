<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
    require_once('bd/BDAdmin.php');
    $bd_admin = new BDAdmin();
    $producto = array();
    $tipo = "info";
    if ($bd_admin->conectar()) {
        switch ($_REQUEST['accion']) {
            case 'buscar_producto':
                $producto = $bd_admin->consultar_productos($_REQUEST['codigo_producto'], true);
                if (count($producto)) {
                    foreach ($producto as $campo => $valor) {
                        $_REQUEST[$campo] = $valor;
                    }
                }
                break;
            case 'actualizar_producto':
                if ($bd_admin->actualizar_producto($_REQUEST)) {
                    $tipo = "success";
                }
                else{
                    $tipo = "warning";
                }
                break;
        }
    }
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Actualización de productos</h1>
        <hr>
        <form method="POST" action="#">
            <div class="form-group row">
                <label for="codigo_producto" class="col-sm-2 col-form-label"><strong>Código</strong></label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="codigo_producto" name="codigo_producto" required="required" value="<?php echo $_REQUEST['codigo_producto'] ?>">
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-default">Buscar</button>
                    <input type="hidden" name="accion" value="buscar_producto">
                </div>
            </div>
        </form>
        <hr>
        <?php if( count($producto) ): ?>
        <form method="POST" action="#">
            <div class="form-group row">
                <label for="nombre_producto" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required="required" value="<?php echo $_REQUEST['nombre_producto'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="peso_producto" class="col-sm-2 col-form-label">Peso</label>
                <div class="col-sm-3 input-group">
                    <input type="number" class="form-control" id="peso_producto" step="any" name="peso_producto" required="required" value="<?php echo $_REQUEST['peso_producto'] ?>">
                    <div class="input-group-addon">
                        <select class="form-control" id="um_producto" name="um_producto" required="required" title="Unidad de medida">
                            <option <?php echo $_REQUEST['um_producto'] == 'Gr' ? "selected" : "" ?> value="Gr">Gr</option>
                            <option <?php echo $_REQUEST['um_producto'] == 'Lb' ? "selected" : "" ?> value="Lb">Lb</option>
                            <option <?php echo $_REQUEST['um_producto'] == 'Kg' ? "selected" : "" ?> value="Kg">Kg</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="marca_producto" class="col-sm-2 col-form-label">Marca</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="marca_producto" name="marca_producto" required="required" value="<?php echo $_REQUEST['marca_producto'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="fabricante_producto" class="col-sm-2 col-form-label">Fabricante</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="fabricante_producto" name="fabricante_producto" required="required" value="<?php echo $_REQUEST['fabricante_producto'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="caracteristicas_producto" class="col-sm-2 col-form-label">Características</label>
                <div class="col-sm-4">
                    <textarea type="text" class="form-control" id="caracteristicas_producto" name="caracteristicas_producto" required="required"><?php echo $_REQUEST['caracteristicas_producto'] ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <input type="hidden" name="accion" value="actualizar_producto">
                    <input type="hidden" name="codigo_producto" value="<?php echo $_REQUEST['codigo_producto'] ?>">
                </div>
            </div>
        </form>
    <?php endif; ?>
    </div>
    <div class="container container-fluid py-md-4">
    <?php
        if ($bd_admin->mensaje!="") {
            echo '<div class="alert alert-'.$tipo.'" role="alert">'.$bd_admin->mensaje.'</div>';
        }
    ?>
    </div>
</body>
</html>
