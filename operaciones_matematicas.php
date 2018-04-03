<!DOCTYPE html>
<html lang="es">
<?php
    include("header.html");
?>
<body>
    
    <div class="container container-fluid py-md-4">
        <h1 class="bd-title" id="content">Operaciones matemáticas</h1>
        <hr>
        <form method="POST" action="#">
            <div class="form-group row">
                <label for="valor1" class="col-sm-2 col-form-label">Valor 1</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="valor1" name="valor1" required="required" value="<?php echo $_REQUEST['valor1'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="valor1" class="col-sm-2 col-form-label">Valor 2</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control" id="valor2" name="valor2" required="required" value="<?php echo $_REQUEST['valor2'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="valor1" class="col-sm-2 col-form-label">Operación</label>
                <div class="col-sm-3">
                    <select class="form-control" id="operacion" name="operacion" required="required">
                        <option value=""></option>
                        <option <?php echo $_REQUEST['operacion'] == '1' ? "selected" : "" ?> value="1">Sumar</option>
                        <option <?php echo $_REQUEST['operacion'] == '2' ? "selected" : "" ?> value="2">Restar</option>
                        <option <?php echo $_REQUEST['operacion'] == '3' ? "selected" : "" ?> value="3">Multiplicar</option>
                        <option <?php echo $_REQUEST['operacion'] == '4' ? "selected" : "" ?> value="4">Dividir</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">Procesar</button>
                </div>
            </div>
            <hr>
        </form>
    </div>
    
    <?php
    $operacion = $_REQUEST['operacion'];
    $valor1 = $_REQUEST['valor1'];
    $valor2 = $_REQUEST['valor2'];
    // Verificar si son iguales
    $iguales = $valor1 == $valor2 ? "Son iguales" : "No son iguales";
    // Verificar cual es mayor
    $tipo = $valor1 > $valor2 ? "mayor" : "menor";
    // Verificar si son iguales
    $tipo = $valor1 == $valor2 ? "igual" : $tipo;
    // Switch para identificar que operacion se debe realizar
    switch ($operacion) {
        case '1':
        $res = $valor1 + $valor2;
        $proceso = "Sumar";
        break;
        case '2':
        $res = $valor1 - $valor2;
        $proceso = "Restar";
        break;
        case '3':
        $res = $valor1 * $valor2;
        $proceso = "Multiplicar";
        break;
        case '4':
        $res = $valor1 / $valor2;
        $proceso = "Dividir";
        break;
    }
    ?>
    <div class="container container-fluid py-md-4">
        <?php
        // Mostrar el proceso a ejecutar
        echo "<h4>Proceso: $proceso</h4>";
        // Mostrar el resultado
        echo "<h4>Resultado: ".  number_format($res, 2)."</h4>";
        // Mostrar si son iguales
        echo "<h4>$iguales</h4>";
        // Mostrar cual de los dos es mayor o menor
        echo "<h4>El primer dato($valor1) es $tipo que el segundo($valor2)</h4>";
        // Mostrar la secuencia de números por medio de un ciclo for
        echo "<h4>Nuestro grupo es el 18, la secuencia es: ";
        for ($i=1; $i <= 18 ; $i++) { 
            echo $i < 18 ? $i.", " : $i;
        }
        echo "</h4>";
        ?>
    </div>
</body>
</html>
