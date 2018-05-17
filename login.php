<?php 
    require_once('bd/BDAdmin.php');
    $bd_admin = new BDAdmin();
    $bd_admin->verificar_conexion();
    if ($_REQUEST['accion']=='Ingresar') {
        $bd_admin->login($_REQUEST);
    }
?>
<html>
<header>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <title>Inventaria&reg;</title>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
        <style type="text/css">
            #login{
                width: 50%; margin: 0 auto;
                border: 1px solid lightgray;
                padding: 3%;
            }
        </style>
    </head>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Inventaria&reg;</a>
    </nav>
</header>
<body> 
    <div class="container container-fluid py-md-4">
        <div id="login">
            <h1 class="bd-title text-center" id="content">Inicio de sesión</h1>
            <hr>
            <form method="POST" action="#">

                <div class="form-group row">
                    <label for="nombre_usuario" class="col-sm-2 col-form-label">Usuario</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="clave_usuario" class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="clave_usuario" name="clave_usuario" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-primary" name="accion" value="Ingresar">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container container-fluid py-md-4">
    <?php if ($bd_admin->mensaje!="") echo '<div class="alert alert-info" role="alert">'.$bd_admin->mensaje.'</div>'; ?>
    </div>
</body>
</html>