
    <?php include 'sections/fake_head.php' ?>
    <div class="fluidBlanco" data-lenguaje="<?= $_SESSION['lenguaje'] ?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php 
                        $usuario = $_SESSION['usuario']['id'];
                        $categoria = $_SESSION['categoria'];
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
                <div class="col-sm-12">
                    <div class="row formularioTransf">
                        <?php
                            if($pagina != 'inicio')
                            {
                                $app['pagina'] = $app['pagina'] == 'login' ? 'DatosGeneralesExperiencia' : $app['pagina'];
                                $grupo_principal = $app['mysql']->runQuery('SELECT id_grupo FROM grupos WHERE url = "'.$app['pagina'].'" AND id_lenguaje = '.$app['lenguaje'])->getRows();
                                $sub_grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_grupo_padre = '.$grupo_principal[0]['id_grupo'].' AND id_lenguaje = '.$app['lenguaje'])->getRows();

                                if($finalizado){
                                    echo '<div class="col-xs-12" style="text-align:center">';
                                        echo '<a style="font-size:1.4em; display:block; width:100%; text-align:center; margin-top:20px; float:left" target="_blank" href="pdf'.$usuario.'-'.$experiencia_fecha.'"><i class="fa fa-file-pdf-o"></i> Descargue aquí su formulario</a>';
                                    echo '</div>';
                                } else {
                                    foreach($sub_grupos as &$grupo){
                                        echo '<div class="col-xs-12">';
                                            if($grupo['id_grupo'] == $grupo['id_grupo_padre'])
                                                echo '<h1 class="tituloForm" style="color:'.$grupo['color'].';">'.str_replace('<br>', '', $grupo['titulo']).'</h1>';
                                            else
                                                echo '<h4 style="color:'.$grupo['color'].';">'.$grupo['titulo'].'</h4>';
                                        echo '</div>';
                                        echo '<div class="col-xs-12">';
                                            if($grupo['descripcion'] != '')
                                                echo '<p class="descripcion">'.$grupo['descripcion'].'</p>';
                                        echo '</div>';
                                        $preguntas = $app['mysql']->runQuery('SELECT * FROM preguntas WHERE id_categoria = "'.$categoria.'" AND id_grupo = '.$grupo['id_grupo'].' AND id_pregunta = id_pregunta_dependiente AND id_lenguaje = '.$app['lenguaje'])->getRows();
                                        $tipos = $app['mysql']->runQuery('SELECT * FROM tipos')->getRows();
                                        if(is_array($preguntas)){
                                            for($i=0; $i<count($preguntas); $i++) {
                                                $size = 12 / $preguntas[$i]['columnas'];
                                                $preguntas_dependientes = $app['mysql']->runQuery('SELECT * FROM preguntas WHERE id_categoria = "'.$categoria.'" AND id_pregunta != id_pregunta_dependiente AND id_pregunta_dependiente = '.$preguntas[$i]['id_pregunta'].' AND id_lenguaje = '.$app['lenguaje'])->getRows();
                                                $respuesta = $app['mysql']->runQuery('SELECT * FROM respuestas WHERE id_experiencia = '.$experiencia.' AND id_usuario = '.$usuario.' AND id_pregunta = '.$preguntas[$i]['id_pregunta'])->getRows();
                                                
                                                /* ¿tiene respuestas? */
                                                $conres = is_array($respuesta); 

                                                echo '<div class="col-xs-'.$size.'" data-role="pregunta" data-rel="'.$preguntas[$i]['id_pregunta'].'" data-type="'.$tipos[$preguntas[$i]['id_tipo']-1]['tipo'].'">';
                                                    echo '<div class="row">';
                                                        echo '<div class="col-xs-12 form-group '.$preguntas[$i]['clases'].'">';
                                                            echo '<label class="'.((!$conres && $pendiente) && $preguntas[$i]['requerida'] == 1 ? 'pendiente' : '').'">'.$preguntas[$i]['pregunta'].'</label>'.($preguntas[$i]['comentarios'] ? '<p><small>'.$preguntas[$i]['comentarios'].'</small></p>' : '');
                                                            switch($tipos[$preguntas[$i]['id_tipo']-1]['tipo']) {
                                                                case 'textarea':
                                                                    echo '<textarea class="form-control" class="question" data-role="respuesta" style="'.$preguntas[$i]['inline'].'" data-rel="'.$preguntas[$i]['id_pregunta'].'">'.($conres ? $respuesta[0]['respuesta'] : '').'</textarea>';
                                                                break;
                                                                case 'text':
                                                                    echo '<input type="text" class="form-control" class="question" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.($conres ? $respuesta[0]['respuesta'] : '').'">';
                                                                break;
                                                                case 'radio':
                                                                    echo '<div class="radio">';
                                                                        $opciones_respuesta = $app['mysql']->runQuery('SELECT opciones FROM opciones WHERE id_pregunta = "'.$preguntas[$i]['id_pregunta'].'" ')->getRows();
                                                                        $opciones = explode(",", $opciones_respuesta[0]['opciones']);
                                                                        $opcion_seleccionada = $conres ? $respuesta[0]['respuesta'] : '';
                                                                        if(is_array($opciones_respuesta) > 0){
                                                                            for($j=0; $j<count($opciones); $j++){
                                                                                echo '<label class="radio-inline" style="'.$preguntas[$i]['inline'].'"><input type="radio" name="pregunta_'.$preguntas[$i]['id_pregunta'].'" class="question" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.$opciones[$j].'" '.($opciones[$j] == $opcion_seleccionada ? 'checked' : '').'>'.$opciones[$j].'</label>';
                                                                            }
                                                                        }else{
                                                                            for($k=1; $k<=5; $k++){
                                                                                echo '<label class="radio-inline" style="'.$preguntas[$i]['inline'].'"><input type="radio" name="pregunta_'.$preguntas[$i]['id_pregunta'].'" class="question" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.$k.'" '.($k == $opcion_seleccionada ? 'checked' : '').'>'.$k.'&nbsp;</label>';
                                                                            }
                                                                        }
                                                                    echo '</div>';
                                                                break;
                                                                case 'select':
                                                                    $opciones_respuesta = $app['mysql']->runQuery('SELECT opciones FROM opciones WHERE id_pregunta = "'.$preguntas[$i]['id_pregunta'].'" ')->getRows();
                                                                    $opciones = explode(",", $opciones_respuesta[0]['opciones']);
                                                                    echo '<select class="form-control" class="question" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" data-value="'.($conres ? $respuesta[0]['respuesta'] : '').'">';
                                                                        echo '<option value="">Seleccionar</option>';
                                                                        for($j=0; $j<count($opciones); $j++){
                                                                            echo'<option value="'.$opciones[$j].'">'.$opciones[$j].'</option>';
                                                                        }
                                                                    echo '</select>';
                                                                break;
                                                                case 'date':
                                                                    echo '<input type="text" class="form-control" data-type="date" class="question" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.($conres ? $respuesta[0]['respuesta'] : '').'">';
                                                                break;
                                                                case 'file':                                                         
                                                                      echo '<div class="file_uploader col-xs-12" style="padding-left:0px;">';
                                                                            if (!$finalizado)
                                                                            {
                                                                               echo '<div class="input-group botonFile">
                                                                                        <label class="input-group-btn">
                                                                                            <span class="btn btn-primary">
                                                                                                Buscar... <input style="display: none;" class="question" data-role="respuesta"  type="file" data-user="'.$usuario.'" data-rel="'.$preguntas[$i]['id_pregunta'].'">
                                                                                            </span>
                                                                                        </label>
                                                                                        <input class="form-control" readonly="" type="text">
                                                                                        <span class="input-group-btn">
                                                                                            <button class="btn btn-default" id="jbtngreen" type="button">
                                                                                                <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span>
                                                                                            </button>
                                                                                        </span>
                                                                                    </div>
                                                                                    <br><br>
                                                                                    <p class="help-block">Agregue hasta 5 archivos cada uno con un máximo de 5 Mb.</p>' ;
                                                                                    echo '<div class="row"><div class="col-xs-12">';
                                                                                        echo '<div class="archivos filesAtach" data-user="'.$usuario.'" data-rel="'.$preguntas[$i]['id_pregunta'].'">';
                                                                                            for($a = 0; $a < count($archivos); $a++){
                                                                                                $filename = explode('/', $archivos[$a]);
                                                                                                 echo '<p><a data-role="file" href="'.$archivos[$a].'">'.mb_strtolower(end($filename), 'UTF-8').'</a>&nbsp;<a href="#" data-role="delete" title="borrar"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a></p>';
                                                                                            }
                                                                                        echo '</div></div>';
                                                                                echo '</div>';
                                                                            } else {
                                                                                 echo '<div class="row"><div class="col-xs-12">';
                                                                                        echo '<div class="archivos filesAtach" data-user="'.$usuario.'" data-rel="'.$preguntas[$i]['id_pregunta'].'">';
                                                                                            for($a = 0; $a < count($archivos); $a++){
                                                                                                $filename = explode('/', $archivos[$a]);
                                                                                                 echo '<p><a data-role="file" href="'.$archivos[$a].'">'.mb_strtolower(end($filename), 'UTF-8').'</a>&nbsp;</p>';
                                                                                            }
                                                                                        echo '</div>
                                                                                    </div>';
                                                                            }
                                                                    echo '</div>';
                                                                break;
                                                                case 'multitext':
                                                                        if (!$finalizado)
                                                                        {
                                                                           echo '<div class="input-group botonFile">
                                                                                    <input type="text" data-role="multitext" data-rel="'.$preguntas[$i]['id_pregunta'].'" class="form-control" placeholder="">
                                                                                    <input type="hidden" class="question" data-role="respuesta" data-rel="'.$preguntas[$i]['id_pregunta'].'" value="'.($conres ? $respuesta[0]['respuesta'] : '').'">
                                                                                </div>
                                                                                <button class="btn btn-default addFile" data-role="add-multitext" data-rel="'.$preguntas[$i]['id_pregunta'].'" type="button">
                                                                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                                                                </button>
                                                                                <p class="help-block">Agregue hasta 5 links diferentes</p>';
                                                                                $links = split(',', ($conres ? $respuesta[0]['respuesta'] : ''));

                                                                                echo '<div class="row">
                                                                                        <div class="col-xs-12">
                                                                                            <div class="links linksAtach" data-role="lista-multitext" data-rel="'.$preguntas[$i]['id_pregunta'].'">';
                                                                                            for($a = 0; $a < count($links); $a++)
                                                                                            {
                                                                                                if($links[$a] != '') echo '<p><a data-role="file" href="'.$links[$a].'">'.$links[$a].'</a>&nbsp;<a href="#" data-role="delete" title="borrar"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a></p>';
                                                                                            }
                                                                                    echo '</div>
                                                                                    </div>
                                                                                </div>';
                                                                        } else {
                                                                            $links = split(',', ($conres ? $respuesta[0]['respuesta'] : ''));

                                                                            echo '<div class="row">
                                                                                    <div class="col-xs-12">
                                                                                        <div class="links linksAtach" data-role="lista-multitext" data-rel="'.$preguntas[$i]['id_pregunta'].'">';
                                                                                            for($a = 0; $a < count($links); $a++)
                                                                                            {
                                                                                                if($links[$a] != '') echo '<p><a data-role="file" href="'.$links[$a].'">'.$links[$a].'</a>&nbsp;</p>';
                                                                                            }
                                                                                    echo '</div>
                                                                                    </div>
                                                                                </div>';
                                                                        }
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
                                                                    echo '<div class="col-xs-12 form-group inset-form-group">';
                                                                        echo '<label class="'.(!$conderes && $pendiente ? 'pendiente' : '').'" style="margin-top:0px;">'.$preguntas_dependientes[$p]['pregunta'].'</label>';
                                                                        switch($tipos[$preguntas_dependientes[$p]['id_tipo']-1]['tipo']) {
                                                                            case 'textarea':
                                                                                echo '<textarea class="form-control" class="question" data-role="respuesta" data-rel="'.$preguntas_dependientes[$p]['id_pregunta'].'">'.($conderes ? $respuesta_dependiente[0]['respuesta'] : '').'</textarea>';
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
                                echo ' <div class="col-sm-12 BotonesForm">';
                                    if( !$finalizado)
                                    {
                                        if ($app['pagina'] == 'InformacionAdicional')
                                        {
                                            echo '<div class="col-sm-12 text-center"><label class="checkbox-inline terminosCondiciones"><input id="acepto" value="option1" type="checkbox"> Acepto los terminos y condiciones</label></div>';
                                        }
                                        echo '<button class="btn btn-default guardar" id="guardar">Guardar</button>';
                                        echo '<button class="btn btn-default enviar" disabled  id="enviar">Enviar</button>';
                                        echo '<p class="infoAdv">Complete todos los campos requeridos para poder enviar</p>';
                                    }
                                echo '</div>';
                        ?>
                            <div class="col-sm-12 pagSeccion">
                                <?php
                                    $pag = 0;
                                    $paginas = [
                                        'DatosGeneralesExperiencia',
                                        'DescripcionExperiencia',
                                        'CaracterizacionDeLaExperiencia',
                                        'DesarrolloSostenible',
                                        'InformacionAdicional'
                                    ];

                                    switch($app['pagina'])
                                    {
                                        case 'DatosGeneralesExperiencia':
                                            $pag = 0;
                                        break;
                                        case 'DescripcionExperiencia':
                                            $pag = 1;
                                        break;
                                        case 'CaracterizacionDeLaExperiencia':
                                            $pag = 2;
                                        break;
                                        case 'DesarrolloSostenible':
                                            $pag = 3;
                                        break;
                                        case 'InformacionAdicional':
                                            $pag = 4;
                                        break;
                                    }

                                    switch ($pag) {
                                        case '0':
                                            $label = 1;
                                            $prev = "";                                            
                                            $next = $paginas[1];
                                        break;
                                        case '1':
                                            $label = 2;
                                            $prev = $paginas[0];
                                            $next = $paginas[2];
                                        break;
                                        case '2':
                                            $label = 3;
                                            $prev = $paginas[1];
                                            $next = $paginas[3];
                                        break;
                                        case '3':
                                            $label = 4;
                                            $prev = $paginas[2];
                                            $next = $paginas[4];
                                        break;
                                        case '4':
                                            $label = 5;
                                            $prev = $paginas[3];
                                            $next = "";
                                        break;
                                    }
                                ?>
                                <a href="<?php echo $prev; ?>" class="btn btn-default <?php echo $prev == "" ? 'disabled' : '' ?>"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
                                <span class="paginacion"><?php echo $label ?> / 5</span>
                                <a href="<?php echo $next; ?>" class="btn btn-default <?php echo $next == "" ? 'disabled' : '' ?>"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'sections/fake_foot.php' ?>
</body>
</html>