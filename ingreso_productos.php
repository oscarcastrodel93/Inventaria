<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Ingreso de productos</h1>
        <hr>
        <form method="POST" action="#">
            <div class="form-group row">
                <label for="codigo_producto" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="codigo_producto" name="codigo_producto" required="required" value="<?php echo $_REQUEST['codigo_producto'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="nombre_producto" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required="required" value="<?php echo $_REQUEST['nombre_producto'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="peso_producto" class="col-sm-2 col-form-label">Peso</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="peso_producto" name="peso_producto" required="required" value="<?php echo $_REQUEST['peso_producto'] ?>">
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
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
