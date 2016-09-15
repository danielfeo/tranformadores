<?php

if($app['pagina'] == 'pdf'){
	include('app/pdf.php');
} elseif ( isset($_SESSION['usuario']) ){
	if($app['pagina'] == 'CambiarDatosUsuario'){
		include('app/CambiarDatosUsuario.php');
	}else if($_SESSION['usuario']['rol'] == 1){
        $app['pagina'] = $app['pagina'] == 'DatosGeneralesExperiencia' ? 'Usuarios' : $app['pagina'];
		include ('app/admin_base.php');
	}else{
		include ('app/base.php');
    }
} elseif ($app['pagina'] == 'Recordar') {
	include('app/recordar.php');
} else {
	include ('app/login.php');
}

?>