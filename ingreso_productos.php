<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
    require_once('bd/BDAdmin.php');
    $bd_admin = new BDAdmin();
    $bd_admin->conectar();
    $tipo = "info";
    if (isset($_REQUEST['codigo_producto'])) {
        if ($bd_admin->crear_producto($_REQUEST)) {
            $tipo = "success";
            $_REQUEST = array();
        }
        else{
            $tipo = "warning";
        }
        
    }
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Ingreso de productos</h1>
        <hr>
        <form method="POST" action="#">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="codigo_producto">Código</label>
                    <input type="number" class="form-control" id="codigo_producto" name="codigo_producto" required="required" value="<?php echo $_REQUEST['codigo_producto'] ?>">
                </div>
                <div class="form-group col-md-4 offset-md-1">
                    <label for="nombre_producto">Nombre</label>
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required="required" value="<?php echo $_REQUEST['nombre_producto'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="peso_producto">Peso</label>
                    <div class="input-group">
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
                <div class="form-group col-md-4 offset-md-1">
                    <label for="marca_producto">Marca</label>
                    <input type="text" class="form-control" id="marca_producto" name="marca_producto" required="required" value="<?php echo $_REQUEST['marca_producto'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="fabricante_producto">Fabricante</label>
                    <input type="text" class="form-control" id="fabricante_producto" name="fabricante_producto" required="required" value="<?php echo $_REQUEST['fabricante_producto'] ?>">
                </div>
                <div class="form-group col-md-4 offset-md-1">
                    <label for="caracteristicas_producto">Características</label>
                    <textarea type="text" class="form-control" id="caracteristicas_producto" name="caracteristicas_producto" required="required"><?php echo $_REQUEST['caracteristicas_producto'] ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>

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
