<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
    require_once('bd/BDAdmin.php');
    $bd_admin = new BDAdmin();
    $productos = array();
    if ($bd_admin->conectar() && isset($_REQUEST['codigo_producto'])) {
        $productos = $bd_admin->consultar_productos($_REQUEST['codigo_producto']);
    }
?>
<body> 
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Consulta de productos</h1>
        <hr>
        <form method="POST" action="#">
            <div class="form-group row">
                <label for="codigo_producto" class="col-sm-2 col-form-label">Código</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="codigo_producto" name="codigo_producto" required="required" value="<?php echo $_REQUEST['codigo_producto'] ?>" 
                        data-toggle="tooltip" 
                        data-placement="right" 
                        title="Para buscar coincidencias, utilice el comodín %. Ejemplo: %123%">
                </div>
            </div>
            <?php if($bd_admin->conectado): ?>
            <div class="form-group row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
            <?php endif; ?>
        </form>
        <hr>
    </div>
    <div class="container container-fluid py-md-4">
        <?php if( count($productos) > 0 ): ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Peso</th>
                    <th>Marca</th>
                    <th>Fabricante</th>
                    <th>Caracteristicas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productos as $key => $row): ?>
                <tr>
                    <td><?php echo $row['codigo_producto']; ?></td>
                    <td><?php echo $row['nombre_producto']; ?></td>
                    <td><?php echo $row['peso_producto'] .' '.$row['um_producto'] ?></td>
                    <td><?php echo $row['marca_producto']; ?></td>
                    <td><?php echo $row['fabricante_producto']; ?></td>
                    <td><?php echo $row['caracteristicas_producto']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <?php
            if ($bd_admin->mensaje!="") {
                echo '<div class="alert alert-info" role="alert">'.$bd_admin->mensaje.'</div>';
            }
        ?>
    </div>
</body>
</html>
