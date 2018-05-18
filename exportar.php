<?php
    require_once('bd/BDAdmin.php');
    $bd_admin = new BDAdmin();
    $bd_admin->auth();

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

        case 'generar_pdf':
            $bd_admin->conectar();
            $bd_admin->auth();
            $productos = $bd_admin->consultar_productos(False);

            $html = '<h3>Productos registrados</h3><hr>';
            foreach ($productos as $key => $row) {
                $html.='
                <table border="0" style="font-size:14px;width:100%;">
                    <tr>
                        <td><strong>Código:</strong></td>
                        <td>'.$row['codigo_producto'].'</td>
                    </tr>
                    <tr>
                        <td><strong>Nombre:</strong></td>
                        <td colspan="3">'.$row['nombre_producto'].'</td>
                    </tr>
                    <tr>
                        <td><strong>Peso:</strong></td>
                        <td>'.$row['peso_producto'].' '.$row['um_producto'].'</td>
                    </tr>
                    <tr>
                        <td><strong>Marca:</strong></td>
                        <td>'.$row['marca_producto'].'</td>
                    </tr>
                    <tr>
                        <td><strong>Fabricante:</strong></td>
                        <td>'.$row['fabricante_producto'].'</td>
                    </tr>
                    <tr>
                        <td><strong>Caracteristicas:</strong></td>
                        <td widht="50">'.$row['caracteristicas_producto'].'</td>
                    </tr>
                </table><hr>';
            }

            require_once('html2pdf/html2pdf.class.php'); 
            $pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', array(10, 10, 10, 10));
            $pdf->WriteHTML($html);
            $pdf->Output();
            break;
            
        case 'backup_bd':
            $filepath = $bd_admin->backup_bd();

            if(file_exists($filepath)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                header("Content-Transfer-Encoding: binary");
                header('Content-Length: ' . filesize($filepath));
                flush(); // Flush system output buffer
                readfile($filepath);
                exit;
            }
            else{
                echo $bd_admin->mensaje;
            }
            break;
            
    }
?>