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
	case 'obtener_experiencias':
		$experiencias = $mysql->runQuery('SELECT id_experiencia, YEAR(inicio) AS año FROM experiencias GROUP BY año DESC')->getRows();
		echo json_encode($experiencias);
	break;
	case 'obtener_usuario_exp':
		$usuarios = $mysql->runQuery('SELECT eu.id_experiencia , u.id_usuario, u.organizacion , u.email , eu.fecha FROM experiencias_usuarios eu, usuarios u WHERE eu.id_usuario = u.id_usuario AND id_experiencia = "'.$_POST['_exp'].'" LIMIT '.$_POST['_pagina'].','.$_POST['_items'])->getRows();
		echo json_encode($usuarios);
	break;
	case 'obtener_total_pag':
		$total = $mysql->runQuery('SELECT COUNT(*)as total FROM experiencias_usuarios eu, usuarios u WHERE eu.id_usuario = u.id_usuario AND  id_experiencia = "'.$_POST['_exp'].'" ')->getRows();
		$paginas = ceil($total[0]['total'] / 10);
		echo json_encode(array('paginas'=> $paginas));
	break;
	default:
	break;
}

?>