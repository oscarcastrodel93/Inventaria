<?php
    switch ($_REQUEST['accion']) {
        case 'reportes_especiales':
            $text = "Datos del producto.\r\n";
            $text .= "Código: ".$_REQUEST['codigo_producto']."\r\n";
            $text .= "Nombre: ".$_REQUEST['nombre_producto']."\r\n";
            $text .= "Peso: ".$_REQUEST['peso_producto']." ".$_REQUEST['um_producto']."\r\n";
            $text .= "Marca: ".$_REQUEST['marca_producto']."\r\n";
            $text .= "Fabricante: ".$_REQUEST['fabricante_producto']."\r\n";
            
            header('Content-type: text/plain');
            header('Content-Disposition: attachment; filename="'.$_REQUEST['codigo_producto'].'.txt"');
            print($text);
            break;
    }
?>