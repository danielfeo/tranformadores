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
$grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_grupo = id_grupo_padre OR id_grupo IN ('.$grupos_preguntas[0]['grupos'].') ORDER BY id_grupo_padre, id_grupo')->getRows();
$usuarios = $app['mysql']->runQuery('SELECT * FROM usuarios WHERE id_usuario = '.$app['pdf_usuario'])->getRows();

$archivos = glob('../'.($lenguaje[0]['id_lenguaje'] == '1' ? 'es' : 'pr').'/public/archivos/'.$app['pdf_usuario'].'/'.$app['pdf_categoria'].'/*');

$mpdf=new mPDF('utf-8', 'A4', 11, '', 15, 15, 35, 15, 12, 0, 'P');
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
$stylesheet = file_get_contents('public/css/pdf.css');
$mpdf->SetHTMLHeader($header);
$html = '<div class="container">
            <div class="main">';
                foreach($grupos as &$grupo)
                {
                    if ($grupo['url'] != 'InformacionAdicional')
                    {
                        if ($grupo['id_grupo'] == $grupo['id_grupo_padre'])
                            $html .= '<h2 style="color:'.$grupo['color'].'; border-bottom-color:'.$grupo['color'].'">'.str_replace('<br>', '', $grupo['titulo']).'</h2>';
                        else 
                            $html .= '<h3 style="color:'.$grupo['color'].';">'.str_replace('<br>', '', $grupo['titulo']).'</h3>';
                        
                        $preguntas = $app['mysql']->runQuery('SELECT p.pregunta, r.* FROM respuestas r, preguntas p, grupos g, experiencias_usuarios e WHERE e.`id_experiencia` = '.$app['pdf_experiencia'].' AND e.`id_categoria` = '.$app['pdf_categoria'].' AND r.`id_experiencia` = e.`id_experiencia` AND p.`id_categoria` = e.`id_categoria` AND r.`id_pregunta` = p.`id_pregunta` AND p.`id_grupo` = g.`id_grupo` AND g.`id_grupo` = '.$grupo['id_grupo'].' AND r.`id_usuario` = '.$app['pdf_usuario'].' ORDER BY r.id_pregunta')->getRows();

                        if (is_array($preguntas))
                        {
                            for ($i=0; $i<count($preguntas); $i++)
                            {
                                $html .= '<div class="item conCalificacion">'.$preguntas[$i]['pregunta'].'<p style="color:#4D4D4D;">'.$preguntas[$i]['respuesta'].'</p></div>';
                            }
                        }
                    }
                }
    /*
    $html .= '<section><h2 class="ColCafe">información adicional</h2>';
    $html .= '<h3>Si desea anexar información, hágalo aquí</h3>';
        $html .= '<div class="item Listalinks">
                    <img src="public/img/link.png" alt="">
                    <ul>';
        for($a = 0; $a < count($archivos); $a++){
            $filename = explode('/', $archivos[$a]);
            $html .= '<li><a href="'.$archivos[$a].'" target="_blank">'.mb_strtolower(end($filename), 'UTF-8').'</a></li>';
        }

       $html .= '</ul></div></section>';*/
    $html .= '</div>
        </div>';

$mpdf->WriteHTML($stylesheet,1);

$mpdf->WriteHTML($html, 2);
$mpdf->Output($usuarios[0]['organizacion'].'_'.$app['pdf_fecha'].'.pdf', 'D');
exit;