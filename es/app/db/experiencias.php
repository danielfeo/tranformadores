<?php session_start();
error_reporting(0);
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
	case 'guardar_experiencia':
		$resultados = $mysql->runQuery('INSERT INTO experiencias(inicio, fin) VALUES("'.$_POST['_fecha_i'].'" , "'.$_POST['_fecha_f'].'")')->getRows();
		echo json_encode(array('estado' => $resultados));
	break;
	case 'obtener_experiencias':
		$experiencias = $mysql->runQuery('SELECT * FROM experiencias LIMIT '.$_POST['_pagina'].' , '.$_POST['_items'].' ')->getRows();
		echo json_encode($experiencias);
	break;
	case 'modificar':
		$resultados = $mysql->runQuery('UPDATE experiencias SET inicio = "'.$_POST['_fecha_i'].'", fin = "'.$_POST['_fecha_f'].'"  WHERE id_experiencia ="'.$_POST['_id'].'" ')->getRows();
		echo json_encode(array('estado' => $resultados));
	break;
	case 'eliminar':
		$consulta = $mysql->runQuery('DELETE FROM experiencias WHERE id_experiencia = "'.$_POST['_id'].'"')->getRows();
		$estado = $consulta;
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