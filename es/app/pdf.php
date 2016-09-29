<?php
include("clases/mpdf/mpdf.php");

$lenguaje = $app['mysql']->runQuery('SELECT p.`id_lenguaje` as id_lenguaje FROM preguntas p, respuestas r, experiencias e WHERE YEAR(e.`inicio`) = "'.$app['pdf_fecha'].'" AND r.`id_experiencia` = e.`id_experiencia` AND r.`id_pregunta` = p.`id_pregunta` AND r.`id_usuario` = '.$app['pdf_user'].' LIMIT 1, 1')->getRows();
$grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_lenguaje = '.$lenguaje[0]['id_lenguaje'])->getRows();
$usuarios = $app['mysql']->runQuery('SELECT * FROM usuarios WHERE id_usuario = '.$app['pdf_user'])->getRows();
$archivos = glob('../'.($lenguaje[0]['id_lenguaje'] == '1' ? 'es' : 'pr').'/public/archivos/'.$app['pdf_user'].'/*');

$mpdf=new mPDF('utf-8', 'A4', 0, '', 15, 15, 30, 16, 9, 9, '');
$header = '<div class="container">
        <div class="header">
            <div class="logo">
                <img width="142px" src="public/img/logo-transformadores.png" alt="">
            </div>
            <div class="tituloForm ColRojo">
                <h1>Comunidades Sostenibles</h1>
            </div>
        </div>
        <div class="fecha">
            Agosto 26 de 2016
        </div><div class="main">';
$stylesheet = file_get_contents('public/css/pdf.css');
$mpdf->SetHTMLHeader($header);
//$html .= '<div class="main"><section><h2 class="ColNaranja">Datos generales de la Experiencia</h2>';
    foreach($grupos as &$grupo){
        $html .= '<section>';
        if($grupo['url'] != 'InformacionAdicional'){
            if($grupo['id_grupo'] == $grupo['id_grupo_padre']){
               $html .= '<h2 class="ColNaranja">'.str_replace('<br>', '', $grupo['titulo']).'</h2>';
            } else {
                $html .= '<div class="item"><h3>'.str_replace('<br>', '', $grupo['titulo']).'t1</h3></div>';
            }
            $preguntas = $app['mysql']->runQuery('SELECT p.pregunta, r.* FROM respuestas r, preguntas p, grupos g, experiencias e WHERE r.`id_pregunta` = p.`id_pregunta`  AND r.`id_experiencia` = e.`id_experiencia` AND p.`id_grupo` = g.`id_grupo`  AND YEAR(e.`inicio`) = "'.$app['pdf_fecha'].'" AND g.`id_grupo_padre` = '.$grupo['id_grupo'].' AND r.`id_usuario` = '.$app['pdf_user'].' order by r.id_pregunta')->getRows();
            for ( $i=0; $i<count($preguntas); $i++ ){
                $html .= '<div class="item"><h3>'.$preguntas[$i]['pregunta'].'</h3><p> '.$preguntas[$i]['respuesta'].'</p></div>';
            }
        }
        $html .= '</section>';
    }

    $html .= '<tr><td colspan="2"><br></td></tr>';
    $html .= '<tr><th colspan="2">Informações adicionais</th></tr>';
    $html .= '<tr><td width="35%" valign="top">Se quiser anexar informação, fazer isso aquí</td>';
        $html .= '<td>';
        for($a = 0; $a < count($archivos); $a++){
            $filename = explode('/', $archivos[$a]);
            $html .= '<a href="'.$archivos[$a].'" target="_blank">'.mb_strtolower(end($filename), 'UTF-8').'</a><br>';
        }
       $html .= '</div></div>';
    
$mpdf->WriteHTML($stylesheet,1);

$mpdf->WriteHTML($html, 2);
$mpdf->Output($usuarios[0]['organizacion'].'_'.$app['pdf_fecha'].'.pdf', 'D');
exit;
