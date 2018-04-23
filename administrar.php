<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
?>
<body> 
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Administrar</h1>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-form-label">
                <label  for="codigo_producto">Crear la base de datos</label>
            </div>
            <div class="col-sm-3">
                <form method="POST" action="bd/procesar.php">
                    <button type="submit" class="btn btn-primary">Crear BD</button>
                    <input type="hidden" class="form-control" name="accion" value="crear_bd">
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-form-label">
                <label  for="codigo_producto">Crear la tabla para la base de datos</label>
            </div>
            <div class="col-sm-3">
                <form method="POST" action="bd/procesar.php">
                    <button type="submit" class="btn btn-primary">Crear tabla</button>
                    <input type="hidden" class="form-control" name="accion" value="crear_tabla">
                </form>
            </div>
        </div>
        <hr>
    </div>
</body>
</html>
