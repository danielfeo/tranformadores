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
$usuario = $_SESSION['usuario']['id'];
$experiencia = $_SESSION['experiencia'];

switch ($accion) {
    case 'guardarPreguntas':
        $estado = true;
        foreach($_POST['_respuestas'] as &$respuesta) {
            $resultado = true;
            $pregunta_anterior = $mysql->runQuery('SELECT * FROM respuestas WHERE id_pregunta = '.$respuesta['id_pregunta'].' AND id_experiencia = '.$experiencia.' AND id_usuario = '.$usuario)->getRows();
            $sql = '';
            if(is_array($pregunta_anterior)){
                if($respuesta['respuesta'] == '')
                    $sql = 'DELETE FROM `respuestas` WHERE `id_respuesta` = '.$pregunta_anterior[0]['id_respuesta'];
                else
                    $sql = 'UPDATE `respuestas` SET `respuesta` = "'.$respuesta['respuesta'].'" WHERE `id_respuesta` = '.$pregunta_anterior[0]['id_respuesta'];
            }else{
                if($respuesta['respuesta'] != '')
                   $sql = 'INSERT INTO `respuestas`(`respuesta`, `id_experiencia`, `id_usuario`, `id_pregunta`) VALUES ("'.$respuesta['respuesta'].'",'.$experiencia.','.$usuario.','.$respuesta['id_pregunta'].')';
            }
            
            if($sql != '')
                $resultado = $mysql->runQuery($sql)->getRows();

            if(!$resultado)
                $estado = false;
        }
        echo json_encode(array('estado' => $estado));
    break;
    case 'enviarPreguntas':
        $total_preguntas = $mysql->runQuery('SELECT COUNT(*) AS total_preguntas FROM preguntas WHERE id_lenguaje = '.$_SESSION['lenguaje'].' AND (id_categoria = '.$_SESSION['usuario']['id_categoria'].' OR id_categoria = 0) AND id_grupo != 16')->getRows();
        $total_respuestas = $mysql->runQuery('SELECT COUNT(*) AS total_respuestas FROM respuestas WHERE id_usuario = '.$usuario.' AND id_experiencia = '.$experiencia.' AND id_pregunta != 143 AND id_pregunta != 144')->getRows();

        if($total_preguntas[0]['total_preguntas'] != $total_respuestas[0]['total_respuestas']){
            $preguntas_pendientes = $mysql->runQuery('SELECT g1.* FROM grupos g1 WHERE g1.`id_lenguaje` = '.$_SESSION['lenguaje'].' AND g1.`id_grupo` IN (SELECT g.`id_grupo_padre` FROM preguntas p, grupos g WHERE p.`id_lenguaje` = '.$_SESSION['lenguaje'].' AND (id_categoria = '.$_SESSION['usuario']['id_categoria'].' OR id_categoria = 0) AND p.`id_pregunta` NOT IN (SELECT id_pregunta FROM respuestas WHERE id_usuario = '.$usuario.' AND id_experiencia = '.$experiencia.') AND p.`id_grupo` = g.`id_grupo` AND g.`id_grupo` != 16)')->getRows();
            $_SESSION['experiencia_actual']['pendientes'] = true;
            echo json_encode(array('estado' => false, 'preguntas' => $preguntas_pendientes));
        }else{
            $usuario_correo = $mysql->runQuery('SELECT * FROM usuarios WHERE id_usuario = '.$usuario)->getRows();
            $experiencia_finalizada = $mysql->runQuery('INSERT INTO experiencias_usuarios (id_experiencia, id_usuario, fecha, finalizado) VALUES ('.$experiencia.', '.$usuario.', CURDATE(), 1)')->getRows();
            $mail->send($mailserver['user'], $mailserver['admin'], 'Nuevo formulario', 'Se ha se ha recibido un nuevo formulario del usuario: '.$usuario_correo[0]['email']);
            $mail->send($mailserver['user'], $usuario_correo[0]['email'], 'Obrigado', 'Obrigado por candidatizar a sua experiência ao Prêmio Transformadores');
            $_SESSION['experiencia_actual']['pendientes'] = false;
            echo json_encode(array('estado' => true, 'preguntas' => array()));
        }
    break;
    case 'cargarArchivo':
        $directorio = '../../public/archivos/'.$usuario.'/';
        $nombre = '';
        $url = '';
        $estado = '1';
        
        if (!file_exists($directorio))
            mkdir($directorio, 0777, true);
        
        if ($_FILES != null){
            foreach ($_FILES as &$key) {
                if($key['error'] == UPLOAD_ERR_OK ){
                    $sobreescribir = false;
                    $nombre = $key['name'];
                    $temporal = $key['tmp_name'];
                    $tamano= ($key['size'] / 1000)."kb";
                    $tipo = $key['type'];
                    
                    $url = $directorio.$nombre;

                    $exp_nombre = explode(".", $nombre);
                    $extension = end($exp_nombre);
                    if ($extension == "pdf" || $extension == "docx" || $extension == "doc" || $extension == "xlsx" || $extension == "xls"){
                        if (file_exists($directorio.$nombre)){
                            if (!$sobreescribir){
                                $i = 1;
                                while ($i) {
                                    if (!file_exists($directorio.$i."_".$nombre)) {
                                        $nombre = $i."_".$nombre;
                                        $i = 0;
                                    } else {
                                        $i++;
                                    }
                                }
                            }
                        }
                        move_uploaded_file($temporal, $directorio.$nombre);
                    }else{
                        $estado = '2';
                    }
                }else{
                    $estado = '3';
                }
            }
        }else{
            $estado = '4';
        }
         echo json_encode(array('estado' => $estado, 'url' => 'public/archivos/'.$usuario.'/'.$nombre, 'file' => mb_strtolower($nombre, 'UTF-8')));
    break;
    case 'borrarArchivo':
        $archivo = '../../'.$_POST['_archivo'];
        $estado = unlink($archivo);
        echo json_encode(array('estado' => $estado));
    break;
    default:
    break;
}