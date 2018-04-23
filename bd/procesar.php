<?php 
	require_once('BDAdmin.php');
	$servidor = "localhost";
	$usuario  = "root";
	$clave    = "12345678";

	$bd_admin = new BDAdmin($servidor, $usuario, $clave);
	if (!$bd_admin) {
		return false;
	}

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
			
		default:
			# code...
			break;
	}
?>