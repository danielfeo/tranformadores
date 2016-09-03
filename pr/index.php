<?php session_start();
error_reporting(0);
include 'database.php';
include 'mailserver.php';
include 'clases/mysql.php';
include 'clases/jmail.php';
$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sábado');
$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

if($_SERVER['SERVER_NAME'] == '192.168.0.12')
    $mysql = new MySQL($conection['local']);
else
    $mysql = new MySQL($conection['server']);

//$mail = new JMail($mailserver['host'], $mailserver['user'], $mailserver['pass'], $mailserver['port'], true);
$lenguajes = array('es' => 1, 'pr' => 2);
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'DatosGeneralesExperiencia';
$app = array();
$app['mysql'] = $mysql;
$app['mail'] = $mail;
$app['pagina'] = $pagina;
$app['lenguaje'] = $lenguajes['es'];

if (0 === strpos($pagina, 'pdf')) {
   $datos = explode('pdf', $pagina);
   $info = explode('-', $datos[1]);
   $user = $info[0];
   $fecha = $info[1];
   $app['pagina'] = 'pdf';
   $app['pdf_user'] = $user;
   $app['pdf_fecha'] = $fecha;
}

$_SESSION['lenguaje'] = $lenguajes['es'];
include 'enrutador.php';
