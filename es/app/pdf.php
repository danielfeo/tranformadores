<?php
include("clases/mpdf/mpdf.php");

$lenguaje = $app['mysql']->runQuery('SELECT p.`id_lenguaje` as id_lenguaje FROM preguntas p, respuestas r, experiencias e WHERE YEAR(e.`inicio`) = "'.$app['pdf_fecha'].'" AND r.`id_experiencia` = e.`id_experiencia` AND r.`id_pregunta` = p.`id_pregunta` AND r.`id_usuario` = '.$app['pdf_user'].' LIMIT 1, 1')->getRows();
$grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_lenguaje = '.$lenguaje[0]['id_lenguaje'])->getRows();
$usuarios = $app['mysql']->runQuery('SELECT * FROM usuarios WHERE id_usuario = '.$app['pdf_user'])->getRows();
$archivos = glob('../'.($lenguaje[0]['id_lenguaje'] == '1' ? 'es' : 'pr').'/public/archivos/'.$app['pdf_user'].'/*');

$mpdf=new mPDF('utf-8', 'A4', 0, '', 15, 15, 30, 16, 9, 9, '');
$header = '<table><tr><td><img src="public/img/logo_premio.png" height="50px"></td></tr></table>';
$stylesheet = file_get_contents('public/css/pdf.css');
$mpdf->SetHTMLHeader($header);
$mpdf->shrink_tables_to_fit = 1;
$mpdf->setFooter('{PAGENO}');

$html .= '<table width="100%" autosize="1">';
    foreach($grupos as &$grupo){
        if($grupo['url'] != 'InformacionAdicional'){
            if($grupo['id_grupo'] == $grupo['id_grupo_padre']){
                $html .= '<tr><th colspan="2">'.str_replace('<br>', '', $grupo['titulo']).'</th></tr>';
            } else {
                $html .= '<tr><th colspan="2" bgcolor="#aaa">'.str_replace('<br>', '', $grupo['titulo']).'</th></tr>';
            }
            $preguntas = $app['mysql']->runQuery('SELECT p.pregunta, r.* FROM respuestas r, preguntas p, grupos g, experiencias e WHERE r.`id_pregunta` = p.`id_pregunta`  AND r.`id_experiencia` = e.`id_experiencia` AND p.`id_grupo` = g.`id_grupo` AND YEAR(e.`inicio`) = "'.$app['pdf_fecha'].'" AND g.`id_grupo` = '.$grupo['id_grupo'].' AND r.`id_usuario` = '.$app['pdf_user'].' order by r.id_pregunta')->getRows();
            for ( $i=0; $i<count($preguntas); $i++ ){
                $html .= '<tr><td width="35%" valign="top">'.$preguntas[$i]['pregunta'].'</td><td>'.$preguntas[$i]['respuesta'].'</td></tr>';
            }
        }
    }
    $html .= '<tr><td colspan="2"><br></td></tr>';
    $html .= '<tr><th colspan="2">información adicional</th></tr>';
    $html .= '<tr><td width="35%" valign="top">Si desea anexar información, hágalo aquí</td>';
        $html .= '<td>';
        for($a = 0; $a < count($archivos); $a++){
            $filename = explode('/', $archivos[$a]);
            $html .= '<a href="'.$archivos[$a].'" target="_blank">'.mb_strtolower(end($filename), 'UTF-8').'</a><br>';
        }
        $html .= '</td>';
    $html .= '</tr>';
$html .= '</table>';

$mpdf->WriteHTML($stylesheet,1);

$mpdf->WriteHTML($html, 2);
$mpdf->Output($usuarios[0]['organizacion'].'_'.$app['pdf_fecha'].'.pdf', 'D');
exit;
