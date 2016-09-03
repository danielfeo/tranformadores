<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transformadores</title>
    <script src="public/js/jquery.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/simple-modal.js"></script>
    <script src="public/js/app.js"></script>
    <script src="public/js/fileupload.js"></script>
    <link rel="stylesheet" href="public/css/normalize.css">
    <link rel="stylesheet" href="public/css/bootstrap.css">
    <link rel="stylesheet" href="public/js/assets/css/simplemodal.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="public/css/app.css">
</head>
<body>
    <nav>
        <?php include 'sections/fake_head.php' ?>
    </nav>
    <section>
        <div id="breadcrump">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <span class="intro"></span>
                        <span ><a href="http://www.redeamerica.org/PremioLatinoamericano.aspx" class="SkinObject">Premio Latinoamericano</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">
                        <?php 
                            $usuario = $_SESSION['usuario']['id'];
                            $archivos = glob('public/archivos/'.$usuario.'/*');
                            $experiencia = $_SESSION['experiencia'];
                            $experiencia_fecha = $_SESSION['experiencia_fecha'];
                            $experiencia_ejecutada = $app['mysql']->runQuery('SELECT * FROM experiencias_usuarios WHERE id_experiencia = '.$experiencia.' AND id_usuario = '.$usuario)->getRows();
                            if(isset($_SESSION['experiencia_actual']['pendientes']))
                                $pendiente = $_SESSION['experiencia_actual']['pendientes'];
                            else
                                $pendiente = false;
                            
                            $finalizado = is_array($experiencia_ejecutada);

                            include 'sections/menu.php'; 
                        ?>
                    </div>
                    <div class="col-xs-9">
                        <div class="row formulario">
                            <?php
                                if($pagina != 'inicio'){
                                    $app['pagina'] = $app['pagina'] == 'login' ? 'DatosGeneralesExperiencia' : $app['pagina'];
                                    $grupo = $app['mysql']->runQuery('SELECT id_grupo FROM grupos WHERE url = "'.$app['pagina'].'" AND id_lenguaje = '.$app['lenguaje'])->getRows();
                                    $sub_grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_grupo_padre = '.$grupo[0]['id_grupo'].' AND id_lenguaje = '.$app['lenguaje'])->getRows();

                                    if($finalizado){
                                        echo '<div class="col-xs-12" style="text-align:center">';
                                            echo '<a style="font-size:1.4em; display:block; width:100%; text-align:center; margin-top:20px; float:left" target="_blank" href="pdf'.$usuario.'-'.$experiencia_fecha.'"><i class="fa fa-file-pdf-o"></i> Descargue aquí su formulario</a>';
                                        echo '</div>';
                                    }else{
                                        foreach($sub_grupos as &$grupo){
                                            echo '<div class="col-xs-12">';
                                                if($grupo['id_grupo'] == $grupo['id_grupo_padre'])
                                                    echo '<h1 style="color:'.$grupo['color'].'; border-bottom-color:'.$grupo['color'].'; '.($grupo['id_grupo'] == 4 ? 'font-size:1.8em;' : '').'">'.str_replace('<br>', '', $grupo['titulo']).'</h1>';
                                                else
                                                    echo '<h3>'.$grupo['titulo'].'</h3>';
                                            echo '</div>';
                                            echo '<div class="col-xs-12">';
                                                if($grupo['descripcion'] != '')
                                                    echo '<p class="descripcion">'.$grupo['descripcion'].'</p>';
                                            echo '</div>';
                                            $preguntas = $app['mysql']->runQuery('SELECT * FROM preguntas WHERE id_grupo = '.$grupo['id_grupo'].' AND id_pregunta = id_pregunta_dependiente AND id_lenguaje = '.$app['lenguaje'])->getRows();
                                            $tipos = $app['mysql']->runQuery('SELECT * FROM tipos')->getRows();
                                            if(is_array($preguntas)){
                                                for($i=0; $i<count($preguntas); $i++) {
                                                    $size = 12 / $preguntas[$i]['columnas'];
                                                    $preguntas_dependientes = $app['mysql']->runQuery('SELECT * FROM preguntas WHERE id_pregunta != id_pregunta_dependiente AND id_pregunta_dependiente = '.$preguntas[$i]['id_pregunta'].' AND id_lenguaje = '.$app['lenguaje'])->getRows();
                                                    $respuesta = $app['mysql']->runQuery('SELECT * FROM respuestas WHERE id_experiencia = '.$experiencia.' AND id_usuario = '.$usuario.' AND id_pregunta = '.$preguntas[$i]['id_pregunta'])->getRows();
                                                    
                                                    /* ¿tiene respuestas? */
                                                    $conres = is_array($respuesta); 

                                                    echo '<div class="col-xs-'.$size.'" data-role="pregunta" data-rel="'.$preguntas[$i]['id_pregunta'].'" data-type="'.$tipos[$preguntas[$i]['id_tipo']-1]['tipo'].'">';
                                                        echo '<div class="row">';
                                                            echo '<div class="col-xs-12">';
                                                                    echo '<h4 class="'.((!$conres && $pendiente) && $preguntas[$i]['requerida'] == 1 ? 'pendiente' : '').'">'.$preguntas[$i]['pregunta'].'<br><span>'.$preguntas[$i]['comentarios'].'</span></h4>';
                                                            echo '</div>';
                                                            echo '<div class="col-xs-12">';
                                                                switch($tipos[$preguntas[$i]['id_tipo']-1]['tipo']) {
                                                                    case 'textarea':
                                                                        echo '<textarea data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'">'.($conres ? $respuesta[0]['respuesta'] : '').'</textarea>';
                                                                    break;
                                                                    case 'text':
                                                                        echo '<input type="text" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.($conres ? $respuesta[0]['respuesta'] : '').'">';
                                                                    break;
                                                                    case 'radio':
                                                                        $opciones_respuesta = $app['mysql']->runQuery('SELECT opciones FROM opciones WHERE id_pregunta = "'.$preguntas[$i]['id_pregunta'].'" ')->getRows();
                                                                        $opciones = explode(",", $opciones_respuesta[0]['opciones']);
                                                                        $opcion_seleccionada = $conres ? $respuesta[0]['respuesta'] : '';
                                                                        if(is_array($opciones_respuesta) > 0){
                                                                            for($j=0; $j<count($opciones); $j++){
                                                                                echo '<input type="radio" name="pregunta_'.$preguntas[$i]['id_pregunta'].'" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.$opciones[$j].'" '.($opciones[$j] == $opcion_seleccionada ? 'checked' : '').'><label class="radio" for="pregunta_'.$preguntas[$i]['id_pregunta'].'">'.$opciones[$j].'</label>';
                                                                            }
                                                                        }else{
                                                                            for($k=1; $k<=5; $k++){
                                                                                echo '<input type="radio" name="pregunta_'.$preguntas[$i]['id_pregunta'].'" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.$k.'" '.($k == $opcion_seleccionada ? 'checked' : '').'><label class="radio" for="pregunta_'.$preguntas[$i]['id_pregunta'].'">'.$k.'</label>';
                                                                            }
                                                                        }
                                                                    break;
                                                                    case 'select':
                                                                        $opciones_respuesta = $app['mysql']->runQuery('SELECT opciones FROM opciones WHERE id_pregunta = "'.$preguntas[$i]['id_pregunta'].'" ')->getRows();
                                                                        $opciones = explode(",", $opciones_respuesta[0]['opciones']);
                                                                        echo '<select data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" data-value="'.($conres ? $respuesta[0]['respuesta'] : '').'">';
                                                                            echo '<option value="">Seleccionar</option>';
                                                                            for($j=0; $j<count($opciones); $j++){
                                                                                echo'<option value="'.$opciones[$j].'">'.$opciones[$j].'</option>';
                                                                            }
                                                                        echo '</select>';
                                                                    break;
                                                                    case 'date':
                                                                        echo '<input type="text" data-type="date" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.($conres ? $respuesta[0]['respuesta'] : '').'">';
                                                                    break;
                                                                    case 'file':
                                                                        echo '<div class="file_uploader">';
                                                                            echo '<div class="col-xs-6" style="padding-left:0px;">';
                                                                                if(!$finalizado){
                                                                                    echo '<input type="file" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'"><br><br>';
                                                                                    echo '<button class="jbtn green" style="min-width:30px !important;"><i class="fa fa-upload"></i></button>';
                                                                                }else{
                                                                                    echo '<ul class="archivos" data-user="'.$usuario.'" data-rel="'.$preguntas[$i]['id_pregunta'].'">';
                                                                                        for($a = 0; $a < count($archivos); $a++){
                                                                                            $filename = explode('/', $archivos[$a]);
                                                                                            echo '<li><a href="#" data-role="delete" title="borrar"><i class="fa fa-trash-o"></i></a> | <a href="'.$archivos[$a].'" data-role="file" target="_blank"><i class="fa fa-file-o"></i> '.mb_strtolower(end($filename), 'UTF-8').'</a></li>';
                                                                                        }
                                                                                    echo '</ul>';
                                                                                }
                                                                            echo '</div>';
                                                                            echo '<div class="col-xs-6">';
                                                                                echo '<ul class="archivos" data-user="'.$usuario.'" data-rel="'.$preguntas[$i]['id_pregunta'].'">';
                                                                                if(!$finalizado){
                                                                                    for($a = 0; $a < count($archivos); $a++){
                                                                                        $filename = explode('/', $archivos[$a]);
                                                                                        echo '<li><a href="#" data-role="delete" title="borrar"><i class="fa fa-trash-o"></i></a> | <a href="'.$archivos[$a].'" data-role="file" target="_blank"><i class="fa fa-file-o"></i> '.mb_strtolower(end($filename), 'UTF-8').'</a></li>';
                                                                                    }
                                                                                }else{

                                                                                }
                                                                                echo '</ul>';
                                                                            echo '</div>';
                                                                        echo '</div>';
                                                                    break;
                                                                    case 'check':
                                                                        echo 'check';
                                                                    break;
                                                                }
                                                            echo '</div>';
                                                            if(is_array($preguntas_dependientes)){
                                                                for ($p=0; $p < count($preguntas_dependientes); $p++) {
                                                                    $respuesta_dependiente = $app['mysql']->runQuery('SELECT * FROM respuestas WHERE id_experiencia = '.$experiencia.' AND id_usuario = '.$usuario.' AND id_pregunta = '.$preguntas_dependientes[$p]['id_pregunta'])->getRows();
                                                                    
                                                                    /* ¿tiene respuestas dependientes? */
                                                                    $conderes = is_array($respuesta_dependiente); 

                                                                    echo '<div class="'.($conderes || $conres ? '' : 'oculto').'" data-role="pregunta" data-dependiente="'.$preguntas_dependientes[$p]['id_pregunta_dependiente'].'" data-rel="'.$preguntas_dependientes[$p]['id_pregunta'].'" data-type="'.$tipos[$preguntas_dependientes[$p]['id_tipo']-1]['tipo'].'">';
                                                                        echo '<div class="col-xs-12">';
                                                                            echo '<h4 class="'.(!$conderes && $pendiente ? 'pendiente' : '').'" style="margin-top:0px;">'.$preguntas_dependientes[$p]['pregunta'].'</h4>';
                                                                        echo '</div>';
                                                                        echo '<div class="col-xs-12">';
                                                                            switch($tipos[$preguntas_dependientes[$p]['id_tipo']-1]['tipo']) {
                                                                                case 'textarea':
                                                                                    echo '<textarea data-role="respuesta" data-rel="'.$preguntas_dependientes[$p]['id_pregunta'].'">'.($conderes ? $respuesta_dependiente[0]['respuesta'] : '').'</textarea>';
                                                                                break;
                                                                            }
                                                                        echo '</div>';
                                                                    echo '</div>';
                                                                }
                                                            }
                                                        echo '</div>';
                                                    echo '</div>';
                                                }
                                            }
                                        }
                                    }
                                    echo '<div class="col-xs-12 botones" style="border-top-color:'.$sub_grupos[0]['color'].'">';
                                        if(!$finalizado){
                                            echo '<div class="col-xs-6 centrar">';
                                                echo '<input type="button" id="guardar">';
                                            echo '</div>';
                                            echo '<div class="col-xs-6 centrar">';
                                                echo '<input type="button" id="enviar">';
                                            echo '</div>';
                                        }
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>