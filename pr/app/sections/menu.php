<?php
$grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_grupo = id_grupo_padre AND id_lenguaje = '.$app['lenguaje'].'')->getRows();
echo '<ul class="secciones">';
    for ($i=0; $i<count($grupos); $i++)
        echo '<li class="'.($app['pagina'] == $grupos[$i]['url'] ? 'active' : '').'" style="background-color:'.$grupos[$i]['color'].';"><a href="'.$grupos[$i]['url'].'">'.$grupos[$i]['titulo'].'</a></li>';
echo '</ul>';