<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Reportes especiales</h1>
        <hr>
        <p class="lead">Datos del producto:</p>
        <form method="POST" action="exportar.php">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="codigo_producto">Código</label>
                    <input type="number" class="form-control" id="codigo_producto" name="codigo_producto" required="required" value="<?php echo $_REQUEST['codigo_producto'] ?>">
                </div>
                <div class="form-group col-md-3 offset-md-1">
                    <label for="nombre_producto">Nombre</label>
                    <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required="required" value="<?php echo $_REQUEST['nombre_producto'] ?>">
                </div>
                <div class="form-group col-md-3 offset-md-1">
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
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="marca_producto">Marca</label>
                    <input type="text" class="form-control" id="marca_producto" name="marca_producto" required="required" value="<?php echo $_REQUEST['marca_producto'] ?>">
                </div>
                <div class="form-group col-md-3 offset-md-1">
                    <label for="fabricante_producto">Fabricante</label>
                    <input type="text" class="form-control" id="fabricante_producto" name="fabricante_producto" required="required" value="<?php echo $_REQUEST['fabricante_producto'] ?>">
                </div>
                <div class="form-group col-md-3 offset-md-1">
                    <br><button type="submit" class="btn btn-primary">Exportar a TXT</button>
                </div>
            </div>
            <input type="hidden" name="accion" value="reportes_especiales">
        </form>
        <hr>
        <div class="form-group row">
            <label for="marca_producto" class="col-sm-6 col-form-label">Informe en PDF de los productos registrados en la base de datos</label>
            <div class="col-sm-3">
                <button type="button" class="btn btn-info" onclick="window.open('exportar.php?accion=generar_pdf')">Generar</button>
            </div>
        </div>
        <hr>
    </div>
</body>
</html>
