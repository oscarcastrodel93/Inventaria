<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Consulta de productos</h1>
        <hr>
        <form method="POST" action="#">
            <div class="form-group row">
                <label for="codigo_producto" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="codigo_producto" name="codigo_producto" required="required" value="<?php echo $_REQUEST['codigo_producto'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
        <hr>
    </div>
</body>
</html>
