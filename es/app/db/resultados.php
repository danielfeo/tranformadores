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
		$usuarios = $mysql->runQuery('SELECT eu.id_experiencia, u.id_usuario, c.id_categoria, u.organizacion, u.email, c.descripcion, eu.fecha FROM experiencias_usuarios eu, usuarios u, categoria c WHERE eu.id_usuario = u.id_usuario AND eu.id_categoria = c.id_categoria AND id_experiencia = "'.$_POST['_exp'].'"')->getRows();
		if (count($usuarios) > 0)
		{
			foreach ($usuarios as &$usuario) {
				$lenguaje = $mysql->runQuery('SELECT p.id_lenguaje FROM respuestas r, preguntas p, grupos g, experiencias_usuarios e WHERE e.`id_experiencia` = '.$usuario['id_experiencia'].' AND e.`id_categoria` = '.$usuario['id_categoria'].' AND r.`id_experiencia` = e.`id_experiencia` AND p.`id_categoria` = e.`id_categoria` AND r.`id_pregunta` = p.`id_pregunta` AND p.`id_grupo` = g.`id_grupo` AND r.`id_usuario` = '.$usuario['id_usuario'].' ORDER BY r.id_pregunta')->getRows();
				$usuario['lenguaje'] = $lenguaje[0]['id_lenguaje'] == '1' ? 'Es' : 'Pt';
			}
		}
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