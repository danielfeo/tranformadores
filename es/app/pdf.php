<?php
include("clases/mpdf/mpdf.php");

$ano = date('Y');
$mes = date('n');
$dia = date('d');
$diasemana = date('w');
$diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
$mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha= $mesesN[$mes]." $dia de $ano";

$grupos_preguntas = $app['mysql']->runQuery('SELECT GROUP_CONCAT(DISTINCT p.id_grupo) as grupos FROM preguntas p, respuestas r, experiencias e WHERE e.`id_experiencia` = '.$app['pdf_experiencia'].' AND p.id_categoria = '.$app['pdf_categoria'].' AND r.`id_experiencia` = e.`id_experiencia` AND r.`id_pregunta` = p.`id_pregunta` AND r.`id_usuario` = '.$app['pdf_usuario'])->getRows();
$grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_lenguaje= '.$_SESSION['lenguaje'].' and id_grupo = id_grupo_padre OR id_grupo IN ('.$grupos_preguntas[0]['grupos'].') ORDER BY id_grupo_padre, id_grupo')->getRows();
$usuarios = $app['mysql']->runQuery('SELECT * FROM usuarios WHERE id_usuario = '.$app['pdf_usuario'])->getRows();
$lenguaje = $app['mysql']->runQuery('SELECT p.id_lenguaje FROM respuestas r, preguntas p, grupos g, experiencias_usuarios e WHERE e.`id_experiencia` = '.$app['pdf_experiencia'].' AND e.`id_categoria` = '.$app['pdf_categoria'].' AND r.`id_experiencia` = e.`id_experiencia` AND p.`id_categoria` = e.`id_categoria` AND r.`id_pregunta` = p.`id_pregunta` AND p.`id_grupo` = g.`id_grupo` AND r.`id_usuario` = '.$app['pdf_usuario'].' ORDER BY r.id_pregunta')->getRows();
$archivos = glob('../'.($lenguaje[0]['id_lenguaje'] == '1' ? 'es' : 'pr').'/public/archivos/'.$app['pdf_usuario'].'/'.$app['pdf_categoria'].'/*');
$categoria = $app['mysql']->runQuery('SELECT * FROM categoria WHERE id_categoria = '.$app['pdf_categoria'])->getRows();

$mpdf=new mPDF('utf-8', 'A4', 11, 'Helvetica', 15, 15, 35, 25, 12, 12, 'P');
$header = '<div class="container">
                <div class="header">
                    <table width="100%">
                        <tr>
                            <td width="500px">
                                <img width="142px" src="public/img/logo-transformadores.png" alt="">
                            </td>
                            <td>
                                <span class="tituloForm ColRojo">Comunidades Sostenibles</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="fecha">
                     '.$fecha.'
                </div>
            </div>';
$footer = '<div class="container" style="text-align:center; color:#0071A6; font-size:10px;"> - {PAGENO} / {nb} - </div>';
$stylesheet = file_get_contents('public/css/pdf.css');

$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($footer);
$html = '<div class="container">
            <div class="main">';
                foreach($grupos as &$grupo)
                {

                    if ($grupo['id_grupo'] == $grupo['id_grupo_padre'])
                        $html .= '<h2 style="color:'.$grupo['color'].'; border-bottom-color:'.$grupo['color'].'">'.str_replace('<br>', '', $grupo['titulo']).'</h2>';
                    else 
                        $html .= '<h3 style="color:'.$grupo['color'].';">'.str_replace('<br>', '', $grupo['titulo']).'</h3>';
                    
                    $preguntas = $app['mysql']->runQuery('SELECT p.*, r.* FROM respuestas r, preguntas p, grupos g, experiencias_usuarios e WHERE e.`id_experiencia` = '.$app['pdf_experiencia'].' AND e.`id_categoria` = '.$app['pdf_categoria'].' AND r.`id_experiencia` = e.`id_experiencia` AND p.`id_categoria` = e.`id_categoria` AND r.`id_pregunta` = p.`id_pregunta` AND p.`id_grupo` = g.`id_grupo` AND g.`id_grupo` = '.$grupo['id_grupo'].' AND r.`id_usuario` = '.$app['pdf_usuario'].' ORDER BY r.id_pregunta')->getRows();

                    if (is_array($preguntas))
                    {
                        for ($i=0; $i<count($preguntas); $i++)
                        {
                            if($preguntas[$i]['id_tipo'] != 8) 
                            {
                                $html .= '<div class="item conCalificacion">'.$preguntas[$i]['pregunta'].'<p style="color:#585858;">'.$preguntas[$i]['respuesta'].'</p></div>';
                            } else {
                                $links = explode(',', $preguntas[$i]['respuesta']);
                                if (count($links) > 0)
                                {
                                    $html .= '<div class="item Listalinks">
                                            <br>
                                            <img src="public/img/link.png" alt="">
                                            <ul>';
                                    for ($a = 0; $a < count($links); $a++)
                                    {
                                        if($links[$a] != '')
                                            $html .= '<li><a href="'.(substr($links[$a], 0, 4) === 'http' ? $links[$a] : 'http://'.$links[$a]).'" target="_blank">'.$links[$a].'</a></li>';
                                    }
                                    $html .= '</ul>
                                    </div>';
                                }
                            }
                        }
                    }
                    
                    if ($grupo['url'] == 'InformacionAdicional')
                    {
                        if (count($archivos) > 0)
                        {
                            $html .= '<div class="item Listalinks">
                                            <br>
                                            <img src="public/img/link.png" alt="">
                                            <ul>';
                                    for ($a = 0; $a < count($archivos); $a++)
                                    {
                                        $filename = explode('/', $archivos[$a]);
                                        $html .= '<li><a href="'.$archivos[$a].'" target="_blank">'.mb_strtolower(end($filename), 'UTF-8').'</a></li>';
                                    }
                                    $html .= '</ul>
                                    </div>';
                        }
                    }
                }
    $html .= '</div>
        </div>';

$mpdf->WriteHTML($stylesheet,1);

$mpdf->WriteHTML($html, 2);
$mpdf->Output(trim($usuarios[0]['organizacion']).'_'.date('Ymd').'_'.($categoria[0]['id_categoria'] == '1' ? 'ISP' : 'Negocios' ).'.pdf', 'D');
exit;