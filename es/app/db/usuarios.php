<?php session_start();
error_reporting(1);
include ('../../database.php');
include ('../../mailserver.php');
include ('../../clases/mysql.php');
include ('../../clases/jmail.php');

if($_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == '192.168.0.12')
    $mysql = new MySQL($conection['local']);
else
    $mysql = new MySQL($conection['server']);

$mail = new JMail($mailserver['host'], $mailserver['user'], $mailserver['pass'], $mailserver['port'], true);

$accion = $_POST['_accion'];
switch ($accion) {
	case 'registro':
		$validacion_correo = $mysql->runQuery('SELECT COUNT(*) AS email FROM usuarios WHERE email = "'.$_POST['_correo'].'" ')->getRows();
		if ($validacion_correo[0]['email'] == 1){
			$estado = 2;
		}else{
			$resultado = $mysql->runQuery('INSERT INTO usuarios(organizacion, email, pass, habilitado, id_rol, id_lenguaje) VALUES ("'.$_POST['_organizacion'].'", "'.$_POST['_correo'].'", "'.$_POST['_pass'].'", "'.$_POST['_habilitado'].'", "'.$_POST['_rol'].'", "'.$_POST['_lenguaje'].'")')->getRows();
			$variables_sesion = $mysql->runQuery('SELECT id_usuario, id_rol FROM usuarios WHERE email ="'.$_POST['_correo'].'" AND pass ="'.$_POST['_pass'].'" ')->getRows();
			$estado = $resultado;
			if($estado)
			{
				$mail->send($mailserver['user'], $mailserver['admin'], 'Registro nuevo usuario Redeamerica.org', 'Se ha registrado un nuevo usuario. Organización: '.$_POST['_organizacion'].' Correo: '.$_POST['_correo']);
			}
			if($_POST['_habilitado'] == 1)
			{
				$mail->send($mailserver['user'], $_POST['_correo'], 'Cambio estado Redeamerica.org', 'Se ha habilitado su usuario para diligenciar el formulario en http://www.redeamerica.org/transformadores/pr/');
			}
		}
		echo json_encode(array('estado' => $estado));
	break;
	case 'ingresar':
		$login = $mysql->runQuery('SELECT * FROM usuarios WHERE email = "'.$_POST['_correo'].'" AND pass = "'.$_POST['_pass'].'"')->getRows();
		$lenguaje = $mysql->runQuery('SELECT id_lenguaje FROM usuarios WHERE email = "'.$_POST['_correo'].'" AND pass = "'.$_POST['_pass'].'"')->getRows();
		$experiencia = $mysql->runQuery('SELECT *, YEAR(inicio) as fecha_inicio FROM experiencias WHERE CURDATE() BETWEEN inicio AND fin')->getRows();

		if (is_array($login))
		{
			$estado = 1;
			$lenguaje_valido = $lenguaje[0]['id_lenguaje'] == $_POST['_lenguaje'] ? true : false;

			if($login[0]['id_rol'] == 1 && $login[0]['habilitado'] == '1' && $lenguaje_valido)
			{
				$_SESSION['usuario']['id'] = $login[0]['id_usuario']; 
				$_SESSION['usuario']['rol'] =  $login[0]['id_rol'];
				$_SESSION['categoria'] = $_POST['_categoria'];
			}

			if($login[0]['id_rol'] == 2 && $login[0]['habilitado'] == '1' && $lenguaje_valido) 
			{
				if(is_array($experiencia)) 
				{
					$_SESSION['usuario']['id'] = $login[0]['id_usuario']; 
					$_SESSION['usuario']['rol'] = $login[0]['id_rol'];
					$_SESSION['categoria'] = $_POST['_categoria'];
					$_SESSION['experiencia'] = $experiencia[0]['id_experiencia'];
					$_SESSION['experiencia_fecha'] = $experiencia[0]['fecha_inicio'];
				} else {
					$estado = 2;
				}
			}

			if(!$lenguaje_valido)
			{
				$estado = 4;
			}

			if($login[0]['habilitado'] == '0') 
			{
				$estado = 3;
			}
		}else{
			$estado = 0;
		}
		
		echo json_encode(array('estado' => $estado , 'rol' => $_SESSION['rol']));
	break;
	case 'obtener_usuarios':
		$usuarios = $mysql->runQuery('SELECT u.* FROM usuarios u')->getRows();
		echo json_encode($usuarios);
	break;
	case 'modificar':
		$consulta = $mysql->runQuery('UPDATE usuarios SET organizacion = "'.$_POST['_organizacion'].'", email = "'.$_POST['_correo'].'", pass = "'.$_POST['_pass'].'" , habilitado ="'.$_POST['_habilitado'].'", id_rol ="'.$_POST['_rol'].'", id_lenguaje ="'.$_POST['_lenguaje'].'" WHERE id_usuario ="'.$_POST['_id'].'" ')->getRows();
		if($_POST['_habilitado'] == 1)
		{
			$mail->send($mailserver['user'], $_POST['_correo'], 'Cambio estado Redeamerica.org', 'Se ha habilitado su usuario para diligenciar el formulario en http://www.redeamerica.org/transformadores/pr/');
		}
		$estado = $consulta;
		echo json_encode(array('estado' => $estado));
	break;
	case 'eliminar':
		$consulta = $mysql->runQuery('DELETE FROM usuarios WHERE id_usuario = "'.$_POST['_id'].'"')->getRows();
		$estado = $consulta;
		echo json_encode(array('estado' => $estado));
	break;
	case 'recordar_contraseña':
		$consulta = $mysql->runQuery('SELECT pass FROM usuarios WHERE email = "'.$_POST['_usuario'].'"')->getRows();
		echo $_POST['usuario'];
		if (is_array($consulta)){
			$estado = $mail->send($mailserver['user'], $_POST['_usuario'], 'Recordatorio de clave Redeamerica.org', 'Su clave actual es : '.$consulta[0]['pass'].' ');
		}else{
			$estado = 0;
		}
		echo json_encode(array('estado' => $estado));
	break;
	case 'cambiar_contraseña':
		$consultaus = $mysql->runQuery('SELECT * FROM usuarios where pass = "'.$_POST['_contra_ant'].'" ')->getRows(); 
		if(is_array($consultaus)){
			$consulta = $mysql->runQuery('UPDATE usuarios SET pass = "'.$_POST['_contra_nueva'].'" where id_usuario ="'.$_SESSION['usuario']['id'].'"')->getRows();
			$estado = $consulta;
		}else{
			$estado = 0;
		}
		echo json_encode(array('estado' => $estado));
	break;
	case 'cerrar_sesion':
		$_SESSION = array();
		session_destroy();
	break;
	default:
	break;
}


?>